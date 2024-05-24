#syntax=docker/dockerfile:1.4
FROM php:8.3-fpm-alpine3.17

RUN set -eux && \
    apk update && \
    apk add --no-cache patch bash py3-pip supervisor nodejs yarn npm && \
    apk del && \
    rm -rf /var/lib/apt/lists/* && \
    mkdir /root/history

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer opcache intl pcov pcntl pdo_pgsql pgsql xdebug amqp && \
    ln -s composer /usr/local/bin/c

RUN mkdir -p /var/log/supervisord
RUN pip install yacron

COPY --link fpm.conf /usr/local/etc/php-fpm.d/zzz-docker.conf

COPY wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
