#!/bin/bash

php app/console assets:install --env=prod --symlink
php app/console cache:clear --env=prod
php app/console cache:warmup --env=prod
php app/console assetic:dump --env=prod --no-debug


