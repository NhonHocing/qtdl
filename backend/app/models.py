from django.db import models
from django.core.validators import MinValueValidator

# Create your models here.
# Account
class Account(models.Model):
    username = models.CharField(max_length=150, unique=True)
    password = models.CharField(max_length=128)
    email = models.EmailField(unique=True)

    def __str__(self):
        return self.username

# Loại phòng
class RoomType(models.Model):
    ma_loai = models.AutoField(primary_key=True, editable=False)
    ten_loai = models.CharField(max_length=100)
    gia_phong = models.DecimalField(max_digits=10, decimal_places=2, validators=[MinValueValidator(0)]) #Thap nhất là 0

    def __str__(self):
        return self.ten_loai
    
# Phòng    
class Room(models.Model):
    TRANG_THAI_CHOICES = [
        ('empty', 'Trống'),
        ('using', 'Đang sử dụng'),
    ]

    id = models.AutoField(primary_key=True)
    ma_phong = models.CharField(max_length=14,editable=False)
    ma_loai = models.ForeignKey(RoomType,related_name='rooms', on_delete=models.CASCADE)
    so_phong = models.CharField(max_length=10, unique=True)
    trang_thai = models.CharField(max_length=20, choices=TRANG_THAI_CHOICES)

    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['ma_loai', 'ma_phong'], name='unique_room_type_and_code')
        ]

# Nhân viên
class Staff(models.Model):
    ma_nhan_vien = models.UUIDField(primary_key=True,editable=False)
    ho_ten = models.CharField(max_length=100)
    ngay_sinh = models.DateField()
    so_dien_thoai = models.CharField(max_length=15)

# Khách hàng
class Customer(models.Model):
    ma_khach_hang = models.UUIDField(primary_key=True,editable=False)
    ten_khach_hang = models.CharField(max_length=100)
    dia_chi = models.TextField()
    so_dien_thoai = models.CharField(max_length=15)

# Dịch vụ
class Service(models.Model):
    ma_dich_vu = models.AutoField(primary_key=True,editable=False)
    ten_dich_vu = models.CharField(max_length=100)
    gia_dich_vu = models.DecimalField(max_digits=10, decimal_places=2, validators=[MinValueValidator(0)])

# Thuê phòng
class Rent(models.Model):
    TRANG_THAI_CHOICES = [
        ('order', 'Đã đặt'),
        ('using', 'Đang ở'),
        ('returned', 'Đã trả'),
    ]

    id = models.AutoField(primary_key=True)
    ma_thue = models.UUIDField(editable=False)
    ma_khach_hang = models.ForeignKey(Customer,related_name='rents', on_delete=models.CASCADE)
    ma_phong = models.ForeignKey(Room,related_name='rents', on_delete=models.CASCADE)
    ngay_thue = models.DateField()
    ngay_nhan = models.DateField()
    ngay_tra = models.DateField()
    trang_thai = models.CharField(max_length=20, choices=TRANG_THAI_CHOICES)

    # def clean(self):
    #     if self.ngay_thue > self.ngay_nhan:
    #         raise ValidationError("Ngày thuê không được sau ngày nhận.")
    #     if self.ngay_tra < self.ngay_nhan:
    #         raise ValidationError("Ngày trả phải sau hoặc bằng ngày nhận.")
    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['ma_thue', 'ma_khach_hang', 'ma_phong'], name='unique_rent_customer_room')
        ]

# Sử dụng dịch vụ
class ServiceUsage(models.Model):
    id = models.AutoField(primary_key=True)
    ma_sddv = models.UUIDField(editable=False)
    ma_thue = models.ForeignKey(Rent,related_name='service_usages', on_delete=models.CASCADE)
    ma_dich_vu = models.ForeignKey(Service,related_name='service_usages', on_delete=models.CASCADE)
    so_luong = models.PositiveIntegerField(validators=[MinValueValidator(1)])
    ngay_su_dung = models.DateField()

    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['ma_sddv', 'ma_thue', 'ma_dich_vu'], name='unique_service_usage')
        ]

# Hóa đơn
class Invoice(models.Model):
    ma_hoa_don = models.CharField(max_length=10, primary_key=True)
    ma_sddv = models.ForeignKey(ServiceUsage,related_name='invoices', on_delete=models.CASCADE)
    ngay_lap_hoa_don = models.DateField()
    tong_tien = models.DecimalField(max_digits=12, decimal_places=2, validators=[MinValueValidator(0)])

    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['ma_hoa_don', 'ma_sddv'], name='unique_invoice_service_usage')
        ]