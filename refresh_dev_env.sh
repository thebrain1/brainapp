#!/bin/bash

php app/console assets:install --env=dev --symlink
php app/console assetic:dump --env=dev --no-debug
php app/console cache:clear --env=dev