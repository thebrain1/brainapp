@ECHO OFF
rem # refresh_dev_env.bat
rem # 
rem # Aktualisiert die Entwicklungsumgebung des Webservers (app_dev.php)
rem #   - installiert Assets 
rem #   - Cache wird aktualisiert

php app/console assets:install --env=dev --symlink
php app/console cache:clear --env=dev
php app/console cache:warmup --env=dev