# Payment service
Payment service mocking several processor to run in local

## Install
```shell
composer install
./bin/console server:start
```

With [Docker](docker/README.md)

## Make

Commands list:

- install: Installs the project requirements
- run: Run symfony server
- stop: Stops the symfony server
- logs: Show logs
- clear: Clear cache and database
- test: Run phpunit
- check: Run phpcs and phpstan

## Gateway configuration
### LemonWay 
```
client_login: login
client_password: password
direckit_url: http://0.0.0.0:8000/api/v1/lemonway 
webkit_url: http://0.0.0.0:8000/api/v1/lemonway 
```

### MangoPay 
```
api_base_url: http://0.0.0.0:8000/api/v1/mangopay 
```
