#!/bin/sh

cd /var/www

/usr/src/chmod -R 777 /var/www/storage
php artisan test --profile

php artisan migrate --seed --force
php artisan cache:clear
php artisan queue:restart

/usr/bin/supervisord -n -c /etc/supervisord.conf
/usr/src/artisan queue:restart --tries=3 --verbose --timeout=30 --sleep=3 --rest=1 --max-jobs=1000 --max-time=3600
