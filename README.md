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

// REACT

./vendor/bin/sail npm install react react-dom --save
./vendor/bin/sail npm install --save-dev vite @vitejs/plugin-react

==

./vendor/bin/sail up -d
cp .env.example .env
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed

./vendor/bin/sail artisan test
