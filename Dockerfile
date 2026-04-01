FROM alpine:3.21

LABEL maintainer="Binx Professional Cleaning <info@binx.ca>"
LABEL description="Window Cleaning Cost Calculator — Python engine for commercial facility managers in Northern Ontario"
LABEL org.opencontainers.image.source="https://github.com/DaveCookVectorLabs/window-cleaning-2026"
LABEL org.opencontainers.image.url="https://www.binx.ca/"
LABEL org.opencontainers.image.vendor="Binx Professional Cleaning"
LABEL org.opencontainers.image.licenses="MIT"

RUN apk add --no-cache python3 py3-pip && \
    python3 -m venv /app/venv

WORKDIR /app

COPY engines/python/requirements.txt .
RUN /app/venv/bin/pip install --no-cache-dir -r requirements.txt

COPY engines/python/engine.py .
COPY engines/python/models.py .

EXPOSE 8001

CMD ["/app/venv/bin/python", "engine.py"]
