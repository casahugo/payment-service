start:
	./start.sh
	make install

stop:
	docker-compose stop -t 10; \
	cd -;

restart: stop start

install:
	docker-compose exec php bin/install;

shell:
	docker-compose exec php bash;

check:
	make test
	make phpstan
	make phpcs

test:
	docker-compose exec php ./vendor/bin/phpunit;

phpstan:
	docker-compose exec php ./vendor/bin/phpstan analyse --ansi -c phpstan.neon;

phpcs:
	docker-compose exec php ./vendor/bin/phpcs;

