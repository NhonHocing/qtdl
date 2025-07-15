from rest_framework import serializers
from django.contrib.auth.hashers import make_password, check_password
from django.db.models import Q
from .models import (
                    Room, 
                    RoomType, 
                    Staff, 
                    Customer, 
                    Service, 
                    Rent, 
                    ServiceUsage, 
                    Invoice,
                    Account)

class StaffSerializer(serializers.ModelSerializer):
    class Meta:
        model = Staff
        fields = ['ma_nhan_vien', 'ho_ten', 'ngay_sinh', 'so_dien_thoai', 'role']
        extra_kwargs = {
            'ma_nhan_vien': {
                'read_only': True,  # Không cho phép client nhập mã nhân viên
                'validators': []    # Bỏ validate unique
            }
        }

class CustomerSerializer(serializers.ModelSerializer):
    class Meta:
        model = Customer
        fields = ['ma_khach_hang', 'ten_khach_hang', 'dia_chi', 'so_dien_thoai']
        extra_kwargs = {
            'ma_khach_hang': {
                'read_only': True,  # Không cho phép client nhập mã khách hàng
                'validators': []    # Bỏ validate unique
            }
        }

    def update(self, instance, validated_data):
        password = validated_data.pop('password', None)
        for attr, value in validated_data.items():
            setattr(instance, attr, value)
        if password:
            instance.set_password(password)
        instance.save()
        return instance

class LoginSerializer(serializers.Serializer):
    username = serializers.CharField()
    password = serializers.CharField(write_only=True)

    def validate(self, data):
        username = data.get('username')
        password = data.get('password')

        try:
            user = Account.objects.get(username=username)
        except Account.DoesNotExist:
            raise serializers.ValidationError("Tài khoản không tồn tại.")

        if not check_password(password, user.password):
            raise serializers.ValidationError("Mật khẩu không chính xác.")

        data['user'] = user
        return data

class RentSerializer(serializers.ModelSerializer):
    ma_khach_hang = serializers.PrimaryKeyRelatedField(
        queryset=Customer.objects.all()    )

    ma_phong = serializers.PrimaryKeyRelatedField(
        queryset=Room.objects.all()
    )

    class Meta:
        model = Rent
        fields = [
            'ma_thue', 'ma_khach_hang', 'ma_phong',
            'ngay_thue', 'ngay_nhan', 'ngay_tra', 'trang_thai','ma_nhan_vien'
        ]
        extra_kwargs = {
            'ma_thue': {
                'read_only': True,  # Không cho phép client nhập mã thuê
                'validators': []    # Bỏ validate unique
            }
        }

    def create(self, validated_data):
        khach_hang = validated_data.get('ma_khach_hang', None)
        phong = validated_data.get('ma_phong', None)
        ngay_nhan_new = validated_data.get('ngay_nhan',None)
        ngay_thue_new = validated_data.get('ngay_thue', None)
        ngay_tra_new = validated_data.get('ngay_tra', None)

        if not khach_hang or not phong:
            raise serializers.ValidationError("Khách hàng và phòng là bắt buộc.")
        
        if not ngay_nhan_new or not ngay_thue_new or not ngay_tra_new:
            raise serializers.ValidationError("Ngày nhận, ngày thuê và ngày trả là bắt buộc.")

        if ngay_thue_new > ngay_nhan_new:
            raise serializers.ValidationError("Ngày thuê không được sau ngày nhận.")
        if ngay_tra_new < ngay_nhan_new:
            raise serializers.ValidationError("Ngày trả phải sau hoặc bằng ngày nhận.") 

        valid_rent = True
        if phong.trang_thai == 'Trống':
            conflict=Rent.objects.filter(
                Q(ma_phong=phong) & 
                (Q(trang_thai='Đã đặt') | Q(trang_thai='Đang ở')) &
                ((Q(ngay_tra__gte=ngay_nhan_new) & Q(ngay_nhan__lte=ngay_nhan_new)) |
                (Q(ngay_tra__gte=ngay_tra_new) & Q(ngay_nhan__lte=ngay_tra_new)) |
                (Q(ngay_tra__lt=ngay_tra_new) & Q(ngay_nhan__gt=ngay_nhan_new))
                )).exists()
            if conflict:
                valid_rent = False
        else:
            valid_rent = False
            
        if valid_rent:
            rent=Rent.objects.create(**validated_data)
            return rent
        else:
            raise serializers.ValidationError("Phòng đã được đặt hoặc đang sử dụng trong khoảng thời gian này.")
    
    
class RoomSerializer(serializers.ModelSerializer):
    # ma_loai = serializers.PrimaryKeyRelatedField(
    #     queryset=RoomType.objects.all(), required=False
    # )
    so_tang = serializers.CharField( required=False)
    so_phong = serializers.CharField(required=False)
    
    class Meta:
        model = Room
        fields = ['ma_loai', 'so_phong', 'trang_thai', 'ma_phong','so_tang']
        extra_kwargs = {
            'ma_phong': {
                'read_only': True,  # Không cho phép client nhập má phòng
                'validators': []    # Bỏ validate unique
            }
        }
    
    def create(self ,validated_data):
        so_tang = validated_data.pop('so_tang', None)
        so_phong = validated_data.get('so_phong', None)
        if so_tang and so_phong:
            so_tang+='-'
            ma_phong = so_tang + so_phong
            if len(ma_phong) == 0 or 'F' not in ma_phong:
                raise serializers.ValidationError("Mã phòng không hợp lệ. Vui lòng nhập lại số tầng + số phòng.")
            if Room.objects.filter(ma_phong=ma_phong).exists():
                raise serializers.ValidationError(f"Mã phòng {ma_phong} đã tồn tại.")
            validated_data['ma_phong'] = ma_phong
            validated_data['so_phong'] = so_phong
            room = Room.objects.create(**validated_data)
            return room
        raise serializers.ValidationError("Vui lòng nhập số tàng và số phòng.")

class InvoiceSerializer(serializers.ModelSerializer):
    id_dat_phong = serializers.PrimaryKeyRelatedField(
        queryset=Rent.objects.all(), many=True, write_only=True,required=False
    )
    id_su_dung_dich_vu = serializers.PrimaryKeyRelatedField(
        queryset=ServiceUsage.objects.all(), many=True, write_only=True,required=False
    )

    class Meta:
        model = Invoice
        fields = ['ma_hoa_don', 'ngay_lap_hoa_don', 'tong_tien','trang_thai' ,'id_dat_phong', 'id_su_dung_dich_vu', 'ma_nhan_vien']

    def create(self, validated_data):
        rents = validated_data.pop('id_dat_phong', None)
        usages = validated_data.pop('id_su_dung_dich_vu',None)
        validated_data['trang_thai'] = validated_data.get('trang_thai', 'Chưa thanh toán')
        if not rents or not usages:
            raise serializers.ValidationError("Vui lòng nhập danh sách id_dat_phong hoặc id_su_dung_dich_vu.")
        # Tạo hóa đơn mới
        invoice = Invoice.objects.create(**validated_data)

        # Gán hóa đơn vào các rent
        for rent in rents:
            rent.hoa_don = invoice
            rent.save()

        # Gán hóa đơn vào các usage
        for usage in usages:
            usage.hoa_don = invoice
            usage.save()

        invoice.save()
        return invoice
    
    def to_representation(self, instance):
        # Chuyển đổi các trường nhiều đối tượng thành dữ liệu có thể trả về trong response
        representation = super().to_representation(instance)
        # Lấy danh sách rent đã liên kết
        rent_list = instance.rents.all()
        if rent_list:
            representation['id_dat_phong'] = [rent.ma_thue for rent in rent_list]
        else:
            representation['id_dat_phong'] = []
        # Lấy danh sách service usage đã liên kết
        usage_list = instance.service_usages.all()
        if usage_list:
            representation['id_su_dung_dich_vu'] = [usage.ma_sddv for usage in usage_list]
        else:
            representation['id_dat_phong'] = []

        return representation
    

class StatisticalRevenueSerializer(serializers.Serializer):
    tong_tien= serializers.SerializerMethodField('get_total_tien')

    class Meta:
        model = Invoice
        fields = ['ma_hoa_don', 'ngay_lap_hoa_don', 'tong_tien']

    def get_total_tien(self, invoice):
        total=0
        for rent in invoice.rents.all():
            day_diff = max(1,(rent.ngay_tra - rent.ngay_nhan).days)
            total += day_diff * rent.phong.gia_phong if rent.phong else 0
        # Cộng thêm tiền dịch vụ
        for usage in invoice.service_usages.all():
            total += usage.so_luong * usage.ma_dich_vu.gia_dich_vu if usage.ma_dich_vu else 0
        return total
    
    def to_representation(self, instance):
        return {
            'total_rooms': Room.objects.count(),
            'total_customers': Customer.objects.count(),
            'total_staff': Staff.objects.count(),
            'total_services': Service.objects.count(),
            'total_rents': Rent.objects.count(),
        }
    
class AccountSerializer(serializers.ModelSerializer):
    email=serializers.EmailField(required=True)
    staff=StaffSerializer(required=False)
    ma_nhan_vien = serializers.SlugRelatedField(
        queryset=Staff.objects.all(),
        slug_field='ma_nhan_vien',
        required=False
    )
    class Meta:
        model = Account
        fields = '__all__'
        extra_kwargs = {
            'password': {'write_only': True}
        }

    def create(self, validated_data):
        staff_data = validated_data.pop('staff', None)
        staff_id = validated_data.get('ma_nhan_vien', None)  # do dùng source='ma_nhan_vien'
        if not staff_data and not staff_id:
            raise serializers.ValidationError({'message_error':"Bạn phải cung cấp staff hoặc staff_id."})

        # Nếu chỉ có staff object, tạo hoặc lấy staff tương ứng
        if staff_data:
            # Ví dụ: tìm hoặc tạo Staff (nếu cần)
            staff_serializer = StaffSerializer(data=staff_data)
            staff_serializer.is_valid(raise_exception=True)
            staff_instance = staff_serializer.save()
            validated_data['ma_nhan_vien'] = staff_instance
        else:
            try:
                staff_instance = Staff.objects.get(ma_nhan_vien=staff_id.ma_nhan_vien)
                validated_data['ma_nhan_vien'] = staff_instance
            except Staff.DoesNotExist:
                raise serializers.ValidationError({'message_error':f"Staff with ID {staff_id} does not exist."})
        
        password = validated_data.pop('password')
        instance = Account(**validated_data)
        instance.password = make_password(password)
        instance.save()
        return instance

    def update(self, instance, validated_data):
        password = validated_data.pop('password', None)
        for attr, value in validated_data.items():
            setattr(instance, attr, value)
        if password:
            instance.password = make_password(password)
        instance.save()
        return instance

class RoomTypeSerializer(serializers.ModelSerializer):
    class Meta:
        model = RoomType
        fields = ['ma_loai', 'ten_loai', 'gia_phong']
        extra_kwargs = {
            'ma_loai': {
                'read_only': True,        # không cho nhập vào từ client
                'validators': []          # bỏ validate unique
            }
        }

class ServiceUsageSerializer(serializers.ModelSerializer):
    ma_dich_vu = serializers.SlugRelatedField(
        queryset=Service.objects.all(),
        slug_field='ma_dich_vu')
    ma_khach_hang = serializers.SlugRelatedField(
        queryset=Customer.objects.all(),
        slug_field='ma_khach_hang')

    class Meta:
        model = ServiceUsage
        fields = ['ma_sddv', 'ma_khach_hang', 'ma_dich_vu', 'so_luong', 'ngay_su_dung','status','ma_nhan_vien']
        extra_kwargs = {
            'ma_sddv': {
                'read_only': True,  # Không cho phép client nhập mã sử dụng dịch vụ
                'validators': []    # Bỏ validate unique
            }
        }

class ServiceSerializer(serializers.ModelSerializer):
    class Meta:
        model = Service
        fields = ['ma_dich_vu', 'ten_dich_vu', 'gia_dich_vu']
        extra_kwargs = {
            'ma_dich_vu': {
                'read_only': True,  # Không cho phép client nhập mã dịch vụ
            }
        }