from django.shortcuts import render
from django.views.generic import TemplateView
from django.db import connection
from django.urls import get_resolver

from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status

from .models import Rent
from .serializers import RentSerializer

# Create your views here.
# Add api here
class RentCreateAPIView(APIView):
    def post(self, request):
        serializer = RentSerializer(data=request.data)
        if serializer.is_valid():
            rent = serializer.save()
            return Response(RentSerializer(rent).data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    
class RentListAPIView(APIView):
    def get(self, request):
        rents = Rent.objects.all()
        serializer = RentSerializer(rents, many=True)
        return Response(serializer.data, status=status.HTTP_200_OK)
    
#Base index view
class IndexView(TemplateView):
    template_name = "index.html"

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)

        # Check database connection
        try:
            connection.ensure_connection()
            context['db_status'] = "✅ Connected"
        except Exception as e:
            context['db_status'] = f"❌ Error: {e}"

        # List all registered URL patterns
        resolver = get_resolver()
        all_urls = []
        for pattern in resolver.url_patterns:
            if hasattr(pattern, 'pattern'):
                path = str(pattern.pattern)
                all_urls.append(path)
        context['all_urls'] = all_urls

        return context