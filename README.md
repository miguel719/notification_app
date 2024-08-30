./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

./vendor/bin/sail artisan route:list
php artisan route:clear

./vendor/bin/sail up -d

./vendor/bin/sail artisan cache:clear

./vendor/bin/sail artisan cache:table

./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan route:clear

./vendor/bin/sail artisan migrate:status
