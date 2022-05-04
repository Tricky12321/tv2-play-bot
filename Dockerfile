FROM php:8.0-zts

RUN apt update && apt install -y \
    htop \
    zsh \
    vim \
    git \
    lsof \
    psmisc \
    zip \
    libzip-dev \
    procps \
    dlang-libevent

RUN mkdir /tv2-play-bot
WORKDIR /tv2-play-bot
RUN docker-php-ext-configure pcntl --enable-pcntl
RUN docker-php-ext-install sockets
RUN pecl install event
RUN docker-php-ext-install zip
RUN docker-php-ext-install pcntl
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-install shmop



RUN apt update && apt install -y \
    chromium
COPY --from=composer /usr/bin/composer /usr/bin/composer
ADD . /tv2-play-bot
WORKDIR /tv2-play-bot
RUN composer up
ADD src /tv2-play-bot/src
WORKDIR /tv2-play-bot
CMD php src/main.php