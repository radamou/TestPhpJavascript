#!/bin/bash
set -e

if [[ "$DOCKER_COMPOSE" = "true" ]]
then
    # When using docker-compose, we complete the installation after launching the container
    # due to host directory mounted into the container
    build.sh

    # Run Doctrine migrations only when using docker-compose.
    # Otherwise, migrations are executed from helm config
    bin/console doctrine:migrations:migrate --no-interaction
fi

apache2-foreground
