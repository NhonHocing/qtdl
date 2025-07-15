from rest_framework import serializers
from .models import Room, RoomType, Staff, Customer, Service, Rent, ServiceUsage, Invoice

class RentSerializer(serializers.ModelSerializer):
    class Meta:
        model = Rent
        fields = '__all__'
        read_only_fields = ['id', 'ma_thue']  # Auto-generated
