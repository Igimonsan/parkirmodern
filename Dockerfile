FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    && docker-php-ext-install mysqli intl

WORKDIR /app
COPY . /app

RUN cp env .env || true

CMD php -S 0.0.0.0:$PORT -t public