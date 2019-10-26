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

