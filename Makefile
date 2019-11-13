install:
	composer install

run:
	make install
	./bin/console server:start 0.0.0.0:5000

stop:
	bin/console server:stop

logs:
	tail -f var/log/dev.log

clear:
	bin/console cache:clear

check:
	make test
	make phpstan
	make phpcs

test:
	./vendor/bin/phpunit

phpstan:
	./vendor/bin/phpstan analyse --ansi -c phpstan.neon

phpcs:
	./vendor/bin/phpcs
