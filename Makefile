.PHONY: mercure

install:
	composer install

run:
	make install
	./bin/console server:start 0.0.0.0:5000
	make mercure

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

mercure:
	JWT_KEY='aVerySecretKey' ADDR='localhost:5001' ALLOW_ANONYMOUS=1 CORS_ALLOWED_ORIGINS=*  bin/mercure
