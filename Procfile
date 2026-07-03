web: php artisan serve --host=0.0.0.0 --port=$PORT
release: php artisan config:clear && php artisan cache:clear && php artisan migrate --force && php artisan storage:link