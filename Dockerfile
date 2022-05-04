FROM php:8.0-zts

RUN apt update && apt install -y \
    zsh \
    vim \
    git \
    chromium

RUN mkdir /tv2-play-bot
WORKDIR /tv2-play-bot
RUN docker-php-ext-install sockets
COPY --from=composer /usr/bin/composer /usr/bin/composer
ADD . /tv2-play-bot
WORKDIR /tv2-play-bot
RUN composer up
ADD src /tv2-play-bot/src
WORKDIR /tv2-play-bot/src
CMD php main.php