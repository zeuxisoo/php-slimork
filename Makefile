help:
	@echo "make install"

install:
	curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off
	php composer.phar install

	chmod 777 cache/views
	chmod 777 log
	mv config/common.php.sample config/common.php
	mv config/database.php.sample config/database.php
