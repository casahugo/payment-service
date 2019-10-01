#!/usr/bin/env bash

set -e

readonly CURRENT_FOLDER=$(pwd)

function addHost() {
    local host=$1

    if [ "$(cat /etc/hosts | grep -c ${host})" -eq 0 ]; then
        sudo /bin/sh -c "echo \"127.0.0.1 ${host}\" >> /etc/hosts"
    fi
}

cd $(dirname $0)

addHost "payment.loc"

docker-compose build
docker-compose stop
docker-compose up -d --remove-orphans

cd ${CURRENT_FOLDER}
