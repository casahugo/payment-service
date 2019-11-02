# Payment service
Payment service mocking several processor to run in local

[![CircleCI](https://circleci.com/gh/anthHugo/payment-service.svg?style=svg)](https://circleci.com/gh/anthHugo/payment-service)

## Requirement
```shell
php 7.1.3
```

## Install
```shell
composer install
./bin/console server:start 0.0.0.0:5000
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

### Smoney 
```
api_base_url: http://0.0.0.0:8000/api/v1/smoney 
```
