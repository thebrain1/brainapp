@ECHO OFF
rem # refresh_prod_env.bat
rem # 
rem # Aktualisiert die Produktivumgebung des Webservers (app.php)
rem #   - installiert und dumpt Assets 
rem #   - Cache wird aktualisiert

php app/console assets:install --env=prod --symlink
php app/console cache:clear --env=prod
php app/console cache:warmup --env=prod
php app/console assetic:dump --env=prod --no-debug