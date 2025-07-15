from django.urls import path
from django.conf import settings
from django.conf.urls.static import static

from .views import IndexView, RentCreateAPIView
from .views import RentListAPIView


# URL patterns for the app
urlpatterns = [
    path('api/rents/create/', RentCreateAPIView.as_view(), name='rent-create'),
    path('api/rents/list/', RentListAPIView.as_view(), name='rent-list'),
    path('', IndexView.as_view(), name='index'),  # Base index view
]

# Include static files in development
urlpatterns += static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)