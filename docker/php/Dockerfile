# the different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/develop/develop-images/multistage-build/#stop-at-a-specific-build-stage
# https://docs.docker.com/compose/compose-file/#target

# "php" stage
FROM php:7.2-fpm-alpine


# install gnu-libiconv and set LD_PRELOAD env to make iconv work fully on Alpine image.
# see https://github.com/docker-library/php/issues/240#issuecomment-763112749
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so
ARG APCU_VERSION=5.1.21
# build for production
ARG APP_ENV=dev

RUN apk add --no-cache --virtual .persistent-deps \
    libjpeg \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    libpng \
    libpng-dev \
    freetype \
    freetype-dev \
    icu \
    icu-dev \
    #libmcrypt \
    #libmcrypt-dev \
    libxml2-dev \
    postgresql-dev \
    yaml-dev

RUN set -xe &&\
    apk add --no-cache --virtual .build-deps &&\
    docker-php-ext-configure bcmath --enable-bcmath &&\
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ &&\
    docker-php-ext-configure intl --enable-intl &&\
    docker-php-ext-configure mbstring --enable-mbstring &&\
    #docker-php-ext-configure mcrypt --enable-mcrypt &&\
    docker-php-ext-configure pdo_pgsql --with-pdo-pgsql &&\
    docker-php-ext-configure opcache --enable-opcache &&\
    docker-php-ext-configure soap --enable-soap &&\
    docker-php-ext-configure zip --enable-zip &&\
    docker-php-ext-install \
        bcmath \
        gd \
        intl \
        mbstring \
        #mcrypt \
        pdo_pgsql \
        opcache \
        soap \
        zip


RUN mkdir -p /usr/src/php/ext/apcu &&\
    curl -L https://github.com/krakjoe/apcu/archive/v$APCU_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/apcu --strip 1 &&\
    echo 'apcu' >> /usr/src/php-available-exts &&\
    docker-php-ext-install apcu

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

CMD ["php-fpm"]

