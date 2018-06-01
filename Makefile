all:
	@echo
	@echo "Commands      : Description"
	@echo "------------- : ------------------"
	@echo "make composer : Download the composer.phar into current directory"
	@echo "make vendor   : Download the required packages into vendor directory"
	@echo "make server   : Run the dev server"
	@echo

composer:
	@rm -rf composer.phar
	@curl https://getcomposer.org/composer.phar -o composer.phar

vendor:
	@php composer.phar install

server:
	@php -S localhost:8080 -t ./public
