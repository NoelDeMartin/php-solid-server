#!/bin/bash
set -e

# Run the Solid test-suite
docker network create testnet

# Build and start Nextcloud server with code from current repo contents:
docker build -t server .
docker run -d --name server --network=testnet server

docker build -t webid-provider https://github.com/pdsinterop/test-suites.git#master:/testers/webid-provider
docker build -t solid-crud https://github.com/pdsinterop/test-suites.git#master:/testers/solid-crud
docker build -t cookie         https://github.com/pdsinterop/test-suites.git#master:servers/php-solid-server/cookie
wget -O /tmp/env-vars-for-test-image.list https://raw.githubusercontent.com/pdsinterop/test-suites/master/servers/php-solid-server/env.list
until docker run --rm --network=testnet webid-provider curl -kI https://server 2> /dev/null > /dev/null
do
  echo Waiting for server to start, this can take up to a minute ...
  docker ps -a
  docker logs server || true
  sleep 1
done
docker ps -a
docker logs server

echo Getting cookie...
export COOKIE="`docker run --cap-add=SYS_ADMIN --network=testnet --env-file /tmp/env-vars-for-test-image.list cookie`"
echo "Running webid-provider tests with cookie $COOKIE"
# docker run --rm --network=testnet --env COOKIE="$COOKIE" --env-file /tmp/env-vars-for-test-image.list webid-provider
docker run --rm --network=testnet --env-file /tmp/env-vars-for-test-image.list solid-crud
# rm /tmp/env-vars-for-test-image.list
# docker stop server
# docker rm server
# docker network remove testnet
