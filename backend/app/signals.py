from django.db.models.signals import pre_save
from django.dispatch import receiver
from .models import RoomType, Customer, Service, Invoice, Staff, Rent, ServiceUsage
from .utils import generate_safe_code

# Signal handlers to set auto-generated codes for models
@receiver(pre_save, sender=RoomType)
def set_roomtype_code(sender, instance, **kwargs):
    if not instance.ma_loai:
        instance.ma_loai = generate_safe_code("RoomType", "RT", length=2)

@receiver(pre_save, sender=Staff)
def set_staff_code(sender, instance, **kwargs):
    if not instance.ma_nhan_vien:
        if instance.role == 'admin':
            instance.ma_nhan_vien = generate_safe_code("Admin", "AD", length=3)
        else:
            instance.ma_nhan_vien = generate_safe_code("Staff", "NV", length=3)

@receiver(pre_save, sender=Customer)
def set_customer_code(sender, instance, **kwargs):
    if not instance.ma_khach_hang:
        instance.ma_khach_hang = generate_safe_code("Customer", "KH", length=3)

@receiver(pre_save, sender=Service)
def set_service_code(sender, instance, **kwargs):
    if not instance.ma_dich_vu:
        instance.ma_dich_vu = generate_safe_code("Service", "DV", length=3)

@receiver(pre_save, sender=Rent)
def set_rent_code(sender, instance, **kwargs):
    if not instance.ma_thue:
        instance.ma_thue = generate_safe_code("Rent", "TH", length=4)

@receiver(pre_save, sender=ServiceUsage)
def set_service_usage_code(sender, instance, **kwargs):
    if not instance.ma_sddv:
        instance.ma_sddv = generate_safe_code("ServiceUsage", "SDDV", length=4)

@receiver(pre_save, sender=Invoice)
def set_invoice_code(sender, instance, **kwargs):
    if not instance.ma_hoa_don:
        instance.ma_hoa_don = generate_safe_code("Invoice", "HD", length=4)