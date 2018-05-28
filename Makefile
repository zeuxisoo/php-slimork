all:
	@echo
	@echo "Commands      : Description"
	@echo "------------- : ------------------"
	@echo "make composer : Download the composer.phar into current directory"
	@echo "make server   : Run the dev server"
	@echo

composer:
	@rm -rf composer.phar
	@curl https://getcomposer.org/composer.phar -o composer.phar

server:
	@php -S localhost:8080 -t ./public
