all:
	@echo "make composer"

composer:
	@rm -rf composer.phar
	@curl https://getcomposer.org/composer.phar -o composer.phar

server:
	@php -S localhost:8080 -t ./public
