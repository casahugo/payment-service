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