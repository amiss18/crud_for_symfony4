FROM php:7.1-fpm



ARG DOCKER_USER="docker"



RUN apt-get update \
    && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpq-dev \
    libmagickwand-dev \
    libmcrypt-dev \
    libicu-dev \
    libmemcached-dev \
   
    zlib1g-dev \
    libicu-dev \
    g++ \
    git \
    sudo \
    wget \
    vim \
    libsqlite3-dev \
    && docker-php-ext-install \
        bz2 \
        iconv \
        mbstring \
        mysqli \
        pdo_mysql \
        soap \
        zip \
        json \
        intl \
        pdo_sqlite \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer



# Install PhpMetrics
RUN wget -O /phpmetrics.phar http://github.com/phpmetrics/PhpMetrics/raw/master/build/phpmetrics.phar
RUN chmod +x /phpmetrics.phar
RUN mv /phpmetrics.phar /usr/local/bin/phpmetrics


# Add user DOCKER_USER defined in .env & give sudo privilege
RUN adduser --disabled-password --gecos '' ${DOCKER_USER}
RUN adduser ${DOCKER_USER} sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers


# Override default bash config
ADD .bashrc /home/${DOCKER_USER}/.bashrc
RUN chown ${DOCKER_USER}:${DOCKER_USER} /home/${DOCKER_USER}/.bashrc


# Install Php cs-fixer
RUN wget -O /php-cs-fixer-v2.phar http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar
RUN chmod +x /php-cs-fixer-v2.phar
RUN mv /php-cs-fixer-v2.phar /usr/local/bin/php-cs-fixer


# Install NodeJs
RUN curl -o /tmp/setup_node.sh https://deb.nodesource.com/setup_6.x
RUN chmod +x /tmp/setup_node.sh
RUN /tmp/setup_node.sh
RUN apt-get update \
    && apt-get install -y \
    nodejs \
    build-essential

# Add Provisionning Scripts
ADD entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh