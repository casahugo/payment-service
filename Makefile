start:
	docker/start.sh
	make install

stop:
	cd docker; \
	docker-compose stop -t 10; \
	cd -;

restart: stop start

install:
	cd docker; \
	docker-compose exec php bin/install;

shell:
	cd docker; \
	docker-compose exec php bash;

check:
	make test
	make phpstan
	make phpcs

test:
	cd docker; \
    docker-compose exec php ./vendor/bin/phpunit;

phpstan:
	cd docker; \
	docker-compose exec php ./vendor/bin/phpstan analyse --ansi -c phpstan.neon;

phpcs:
	cd docker; \
	docker-compose exec php ./vendor/bin/phpcs;
