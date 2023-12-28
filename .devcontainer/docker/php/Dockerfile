FROM php:8.2.13-fpm

# copy php.ini
COPY php.ini /usr/local/etc/php
COPY --from=composer /usr/bin/composer /usr/bin/composer

# ユーザ'vscode'を作成する
ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

RUN apt-get update \
    && groupadd --gid $USER_GID $USERNAME \
    && useradd -s /bin/bash --uid $USER_UID --gid $USER_GID -m $USERNAME \
    && apt-get install -y sudo \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

RUN apt-get -y install curl \
    git \
    unzip \
    zip \
    vim \
    nodejs \
    npm

# 時刻を日本時間に変更
RUN apt-get update && apt-get install -y tzdata && apt-get clean && rm -rf /var/lib/apt/lists/*
ENV TZ Asia/Tokyo

# 日本語化
RUN apt-get update && apt-get install -y locales \
    && locale-gen ja_JP.UTF-8
ENV LANG ja_JP.UTF-8
ENV LANGUAGE ja_JP:ja

# phpのログディレクトリ作成

# php extensions install
RUN apt-get install -y zlib1g-dev libzip-dev wget gnupg \
    && docker-php-ext-install zip opcache \
    && apt-get install -y libicu-dev \
    && docker-php-ext-install intl bcmath \
    && docker-php-ext-install pdo pdo_mysql

# xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
