FROM php:8.1.6-apache-bullseye

ARG APP_ENV=dev
ENV APP_ENV $APP_ENV
ARG APP_DEBUG=0
ENV APP_DEBUG $APP_DEBUG
ARG XDEBUG=false
ENV XDEBUG $XDEBUG
ENV DIRECTORY_INDEX index.php
ARG DOCKER_COMPOSE=false
ENV DOCKER_COMPOSE $DOCKER_COMPOSE

WORKDIR /srv

# Get a more recent version of node, we only get v12.* on debian 11 otherwise.
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -

RUN apt-get update \
    && apt-get install -y \
        acl \
        git \
        libpq-dev \
        libzip-dev \
        libpng-dev \
        libicu-dev \
        nodejs \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        intl \
        zip \
        gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && usermod -u 1000 www-data \
    && if ["$XDEBUG" = "true" ]; then pecl install xdebug && docker-php-ext-enable xdebug.so; fi

# Install nodejs bridge with JS package managers.
RUN corepack enable

# Add DataDog extension.
RUN if [ "$DOCKER_COMPOSE" != "true" ]; then \
        curl "https://github.com/DataDog/dd-trace-php/releases/download/0.55.0/datadog-php-tracer_0.55.0_amd64.deb" -L -o "datadog-php-tracer.deb" \
        && dpkg -i datadog-php-tracer.deb; \
    fi

# Datadog: Enable tracing of PHP scripts from the CLI
ENV DD_TRACE_CLI_ENABLED=true

COPY . /srv

ENV APACHE_DOCUMENT_ROOT /srv/public
COPY .docker/000-default.conf /etc/apache2/sites-available/
RUN sed -ri -e 's!/var/www/!$APACHE_DOCUMENT_ROOT!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

# Add Amazon RDS certificat for SSL database.
RUN mkdir -p /etc/ssl/certs/ \
    && curl "https://s3.amazonaws.com/rds-downloads/rds-ca-2019-root.pem" -L -o  "/etc/ssl/certs/rds-ca-2019-root.pem";

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# Increase memory limit and change expose php to hide some header exposure
RUN touch /usr/local/etc/php/conf.d/custom.ini \
    && echo "memory_limit = 1024M;" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "display_errors = Off" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "expose_php = Off" >> /usr/local/etc/php/conf.d/custom.ini

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
# Trick used to cache dependencies
COPY composer.json /srv/composer.json
COPY composer.lock /srv/composer.lock
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY .docker/build.sh /usr/local/bin/
RUN ["chmod", "+x", "/usr/local/bin/build.sh"]
RUN if [ "$DOCKER_COMPOSE" != "true" ]; then build.sh; fi

RUN mkdir -p var
RUN chown -R :www-data var && chmod -R g+w var

COPY .docker/run.sh /usr/local/bin/
RUN ["chmod", "+x", "/usr/local/bin/run.sh"]
CMD ["run.sh"]
