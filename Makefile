all:
	@echo
	@echo "Web            : Description"
	@echo "-------------- : ------------------"
	@echo "make composer  : Download the composer.phar into current directory"
	@echo "make vendor    : Download the required packages into vendor directory"
	@echo "make server    : Run the dev server"
	@echo "make migration : Install the migration table to related database"
	@echo
	@echo "Docker                            : Description"
	@echo "--------------------------------- : -----------------"
	@echo "make docker-start                 : Start the docker service"
	@echo "make docker-stop                  : Stop the docker service"
	@echo "make docker-clean-tmp             : Clean the tmp data"
	@echo "make docker-clean-mysql           : Clean the mysql data"
	@echo "make docker-remove-all-containers : Remove all docker containers"
	@echo "make docker-remove-all-images     : Remove all docker images"
	@echo

composer:
	@rm -rf composer.phar
	@curl https://getcomposer.org/composer.phar -o composer.phar

vendor:
	@php composer.phar install

server:
	@php -S localhost:8080 -t ./public

migration:
	@php ./vendor/bin/phinx migrate

docker-start:
	@bash ./docker/scripts.sh start

docker-stop:
	@bash ./docker/scripts.sh stop
	@make docker-clean

docker-clean:
	@make docker-clean-tmp

docker-clean-tmp:
	@rm -rf ./docker/tmp/php/xdebug

docker-clean-mysql:
	@rm -rf ./docker/var/mysql/data

docker-remove-all-containers:
	@bash ./docker/scripts.sh remove-all-containers

docker-remove-all-images:
	@bash ./docker/scripts.sh remove-all-images

docker-refresh:
	@make docker-remove-all-containers
	@echo "-------- -------- -------->"
	@make docker-remove-all-images
	@echo "-------- -------- -------->"
	@make docker-start
