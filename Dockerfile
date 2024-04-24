FROM registry.hibrid-vod.dev:5001/vod/tools/php-7.4-phpunit:latest

COPY composer.json composer.json

RUN composer install

COPY . .

CMD ["vendor/bin/phpunit", "--configuration", "phpunit.xml.dist"]
