FROM python:3.12.8-slim
# Set environment to non-interactive to speed up apt
ENV DEBIAN_FRONTEND=noninteractive

WORKDIR /app
COPY . .

# Install system dependencies only once
RUN apt-get update && apt-get install -y --no-install-recommends \
    gcc \
    default-libmysqlclient-dev \
    pkg-config \
    && pip install --no-cache-dir -r requirements.txt \
    && apt-get purge -y --auto-remove gcc \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN chmod +x /app/entrypoint.sh
ENTRYPOINT ["/app/entrypoint.sh"]