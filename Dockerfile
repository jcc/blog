FROM php:7.4-fpm

COPY . /usr/src/blog
WORKDIR /usr/src/blog

# install tools
RUN apt-get -y update
RUN apt-get -y install git
RUN apt-get -y install vim
RUN apt-get install zip unzip
RUN apt-get -y install libxml2-dev

# install PHP extenstions
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install xml

#node js 
RUN curl -fsSL https://deb.nodesource.com/setup_16.x |  bash -
RUN apt-get install -y nodejs

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install -vvv
RUN npm install
RUN composer update
RUN npm run dev

COPY entrypoint.sh /entrypoint.sh

CMD ["/entrypoint.sh"]

EXPOSE 8000
