#!/bin/bash

echo "Starting setup process..."

# Step 1: Install PHP dependencies using Composer
echo "Installing PHP dependencies..."
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

# Step 2: Start Sail
echo "Starting Sail..."
./vendor/bin/sail up -d

# Wait for Sail to be fully up and running
sleep 10

# Step 3: Install Node.js dependencies using npm
echo "Installing Node.js dependencies..."
./vendor/bin/sail npm install

# Step 4: Copy .env.example to .env and generate the application key
echo "Setting up environment file and generating application key..."
cp .env.example .env
./vendor/bin/sail artisan key:generate

# Step 5: Run migrations and seed the database
echo "Running migrations and seeding the database..."
./vendor/bin/sail artisan migrate --seed

# Step 6: Build front-end assets
echo "Building front-end assets..."
./vendor/bin/sail npm run build

echo "Setup process completed successfully!"
