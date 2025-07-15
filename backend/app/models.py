from django.db import models
from django.core.validators import MinValueValidator, ValidationError

# Create your models here.
class CodeCounter(models.Model):
    key = models.CharField(max_length=50, unique=True)
    last_number = models.PositiveIntegerField(default=0)

    def __str__(self):
        return f"{self.key}: {self.last_number}"

# Nhân viên
class Staff(models.Model):
    ma_nhan_vien = models.CharField(max_length=20, primary_key=True, editable=False)
    ho_ten = models.CharField(max_length=100)
    ngay_sinh = models.DateField()
    so_dien_thoai = models.CharField(max_length=15)
    role = models.CharField(max_length=50, choices=[('admin', 'Admin'), ('staff', 'Staff')], default='staff')

# Account
class Account(models.Model):
    id = models.AutoField(primary_key=True)
    username = models.CharField(max_length=150,unique=True)
    password = models.CharField(max_length=128)
    email = models.EmailField(unique=True)
    ma_nhan_vien = models.OneToOneField(Staff,to_field='ma_nhan_vien', on_delete=models.SET_NULL, related_name='account', editable=False, null=True)

    def __str__(self):
        return self.username

    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['username', 'email'], name='unique_username_email')
        ]

# Loại phòng
class RoomType(models.Model):
    ma_loai = models.CharField(max_length=20, unique=True, editable=False,primary_key=True) 
    ten_loai = models.CharField(max_length=100)
    gia_phong = models.DecimalField(max_digits=10, decimal_places=2, validators=[MinValueValidator(0)]) #Thap nhất là 0

    def __str__(self):
        return self.ten_loai
    
# Phòng    
class Room(models.Model):
    #Trang thai: Trống, Đang sử dụng
    ma_phong = models.CharField(primary_key=True,max_length=20,editable=False)
    ma_loai = models.ForeignKey(RoomType,related_name='rooms', on_delete=models.SET_NULL, null=True)
    so_phong = models.CharField(max_length=10,editable=False)
    trang_thai = models.CharField(max_length=20)

    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['ma_loai', 'ma_phong'], name='unique_room_type_and_code')
        ]

# Khách hàng
class Customer(models.Model):
    ma_khach_hang = models.CharField(max_length=20, primary_key=True, editable=False)
    ten_khach_hang = models.CharField(max_length=100)
    dia_chi = models.TextField()
    so_dien_thoai = models.CharField(max_length=15)

# Dịch vụ
class Service(models.Model):
    ma_dich_vu = models.CharField(max_length=20, primary_key=True, editable=False)
    ten_dich_vu = models.CharField(max_length=100)
    gia_dich_vu = models.DecimalField(max_digits=10, decimal_places=2, validators=[MinValueValidator(0)])

# Hóa đơn
class Invoice(models.Model):
    ma_hoa_don = models.CharField(primary_key=True, max_length=20, editable=False)
    ma_nhan_vien = models.ForeignKey(Staff,related_name='invoices',to_field='ma_nhan_vien', on_delete=models.SET_NULL, null=True)
    ngay_lap_hoa_don = models.DateField()
    trang_thai= models.CharField(max_length=20) # "Chưa thanh toán", "Đã thanh toán"
    tong_tien = models.DecimalField(max_digits=12, decimal_places=2, validators=[MinValueValidator(0)])

# Thuê phòng
class Rent(models.Model):
    TRANG_THAI_CHOICES = [
        ('Đã đặt', 'order'),
        ('Đang ở', 'using'),
        ('Đã trả', 'returned'),
    ]

    ma_thue = models.CharField(primary_key=True,max_length=20, editable=False)
    ma_khach_hang = models.ForeignKey(Customer,related_name='rents',to_field='ma_khach_hang', on_delete=models.SET_NULL, null=True)
    hoa_don = models.ForeignKey(Invoice, related_name='rents',to_field='ma_hoa_don', on_delete=models.SET_NULL, null=True)
    ma_nhan_vien = models.ForeignKey(Staff,related_name='rents',to_field='ma_nhan_vien', on_delete=models.SET_NULL, null=True)
    ma_phong = models.ForeignKey(Room,related_name='rents',to_field='ma_phong', on_delete=models.SET_NULL, null=True)
    ngay_thue = models.DateField()
    ngay_nhan = models.DateField()
    ngay_tra = models.DateField()
    trang_thai = models.CharField(max_length=20, choices=TRANG_THAI_CHOICES)

    def clean(self):
        if self.ngay_thue > self.ngay_nhan:
            raise ValidationError("Ngày thuê không được sau ngày nhận.")
        if self.ngay_tra < self.ngay_nhan:
            raise ValidationError("Ngày trả phải sau hoặc bằng ngày nhận.")
    class Meta:
        constraints = [
            models.UniqueConstraint(fields=['ma_thue', 'ma_khach_hang', 'ma_phong'], name='unique_rent_customer_room')
        ]

# Sử dụng dịch vụ
class ServiceUsage(models.Model):
    #status: 'Chưa thanh toán', 'Đã thanh toán'
    ma_sddv = models.CharField(primary_key=True,max_length=20, editable=False)
    ma_khach_hang = models.ForeignKey(Customer,to_field='ma_khach_hang',related_name='service_usages', on_delete=models.SET_NULL, null=True)
    ma_dich_vu = models.ForeignKey(Service,to_field='ma_dich_vu',related_name='service_usages', on_delete=models.SET_NULL,null=True)
    ma_nhan_vien = models.ForeignKey(Staff,related_name='service_usages',to_field='ma_nhan_vien', on_delete=models.SET_NULL, null=True)
    so_luong = models.PositiveIntegerField(validators=[MinValueValidator(1)])
    ngay_su_dung = models.DateField()
    status = models.CharField(max_length=20, choices=[('Chưa thanh toán', 'Unpaid'), ('Đã thanh toán', 'Paid')], default='Chưa thanh toán')
    hoa_don = models.ForeignKey(Invoice, to_field='ma_hoa_don',related_name='service_usages', on_delete=models.SET_NULL, null=True)