#!/bin/sh

echo "📦 Waiting for database..."
python << END
import time, socket
while True:
    try:
        socket.create_connection(("db", 3306), timeout=3)
        break
    except OSError:
        time.sleep(1)
END
echo "✅ Database is up!"

# Run migrations
echo "⚙️ Running migrations..."
python manage.py makemigrations app
python manage.py makemigrations
python manage.py migrate app
python manage.py migrate
python manage.py loaddata data.json


# Collect static files
echo "📂 Collecting static files..."
python manage.py collectstatic --noinput

# Create superuser (only if not exists)
echo "👤 Creating superuser..."
python manage.py shell << END
from django.contrib.auth import get_user_model
User = get_user_model()
if not User.objects.filter(username='admin').exists():
    User.objects.create_superuser('admin', 'admin@example.com', 'admin123')
    print("✅ Superuser created.")
else:
    print("🔐 Superuser already exists.")
END

# Start Django server
echo "🚀 Starting server..."
exec gunicorn project_qtdl.wsgi:application --bind 0.0.0.0:8000