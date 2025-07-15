from django.contrib import admin

# Register your models here.
admin.site.site_header = "Quản lý khách sạn"
admin.site.site_title = "Quản lý khách sạn"
admin.site.index_title = "Chào mừng đến với trang quản lý khách sạn"
from .models import RoomType, Room, Staff, Customer, Service, Rent, ServiceUsage, Invoice

admin.site.register(RoomType)
admin.site.register(Room)
admin.site.register(Staff)
admin.site.register(Customer)
admin.site.register(Service)
admin.site.register(Rent)
admin.site.register(ServiceUsage)
admin.site.register(Invoice)