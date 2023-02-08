#!/bin/bash
set -e

# Generate cache and parameters.
if [[ "$APP_ENV" != "dev" ]]; then export ARGS="--no-dev"; fi
composer install -n --prefer-dist

# Decrypt local env.
#bin/local_env

if [[ "$DOCKER_COMPOSE" = "true" ]]
then
    echo "Fix permissions"
    HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
    setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX /srv/var
    setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX /srv/var
fi
