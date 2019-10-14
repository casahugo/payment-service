# Payment service
Payment service mocking several processor to run in local

## Docker Requirements

- make
- [Docker](https://docs.docker.com/install/#supported-platforms) >= 18.04.0
- [Docker compose](https://docs.docker.com/compose/install) >= 1.24.0

Test your versions with:

```shell
docker --version
docker-compose --version
```

## Make

Commands list:

- start: Builds the Docker containers and starts the Docker stack
- stop: Stops the docker stack
- restart: Stops and starts the Docker stack
- install: Installs the project requirements:
  - vendor
  - migrations
- shell: Connects to the PHP service into Docker stack

## Access to website

[payment.loc:8010](http://payment.loc:8010)

## configuration

### In your docker project
Retrieve bridge IP
```
docker inspect bridge
> "Gateway": "172.17.0.1"
```

add in your php container
```
extra_hosts:
    - "payment.loc:172.17.0.1"
```


### LemonWay 
```
client_login: login
client_password: password
direckit_url: http://payment.loc:8010/api/v1/lemonway 
webkit_url: http://payment.loc:8010/api/v1/lemonway 
```

### MangoPay 
```
api_base_url: http://payment.loc:8010/api/v1/mangopay 
```
