from django.urls import include, path
from django.conf import settings
from django.conf.urls.static import static
from rest_framework.routers import DefaultRouter

from .views import (IndexView,
                    AccountCreateAPIView,
                    LoginView,
                    BookingViewSet,
                    RevenueStatsAPIView,
                    ExportStatsExcelAPIView,
                    ServiceUsageStatsAPIView,
                    InvoiceViewSet,
                    AccountViewSet,
                    RoomTypeViewSet,
                    RoomViewSet,
                    StaffViewSet,
                    CustomerViewSet,
                    ServiceUsageViewSet,
                    ServiceViewSet)

# URL patterns for the app
router = DefaultRouter()
router.register(r'bookings', BookingViewSet, basename='booking')
router.register(r'invoices', InvoiceViewSet, basename='invoice')
router.register(r'categories/accounts', AccountViewSet, basename='account')
router.register(r'categories/room-types', RoomTypeViewSet, basename='roomtype')
router.register(r'categories/rooms', RoomViewSet, basename='room')
router.register(r'categories/staffs', StaffViewSet, basename='staff')
router.register(r'categories/customers', CustomerViewSet, basename='customer')
router.register(r'categories/service-usages', ServiceUsageViewSet, basename='serviceusage')
router.register(r'categories/services', ServiceViewSet, basename='service')

# Main URL patterns
urlpatterns = [
    
    path('', IndexView.as_view(), name='index'),  # Base index view
    path('api/', include(router.urls)),  # Include the router URLs
    path('api/auth/register/', AccountCreateAPIView.as_view(), name='account-create'),  # Account creation endpoint
    path('api/auth/login/', LoginView.as_view(), name='account-login'),  # Account login endpoint
    path('api/stats/revenue/', RevenueStatsAPIView.as_view(), name='revenue-stats'),  # Revenue statistics endpoint
    path('api/stats/revenue/service-usage/', ServiceUsageStatsAPIView.as_view(), name='revenue-stats-service-usage'),  # Revenue statistics endpoint
    path('api/stats/export/', ExportStatsExcelAPIView.as_view(), name='export-stats-excel'),  # Export statistics to Excel endpoint
]

# Include static files in development
urlpatterns += static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)