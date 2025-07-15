from django.db import transaction
from .models import CodeCounter

def generate_safe_code(key: str, prefix: str, length: int = 4) -> str:
    with transaction.atomic():
        counter, _ = CodeCounter.objects.select_for_update().get_or_create(
            key=key,
            defaults={'last_number': 0}
        )
        counter.last_number += 1
        counter.save()
        return f"{prefix}{str(counter.last_number).zfill(length)}"