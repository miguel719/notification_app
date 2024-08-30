#!/bin/bash

echo "Starting setup process..."

# Step 1: Install PHP dependencies using Sail
echo "Installing PHP dependencies..."
./vendor/bin/sail composer install

# Step 2: Install Node.js dependencies using npm
echo "Installing Node.js dependencies..."
./vendor/bin/sail npm install

# Step 3: Copy .env.example to .env and generate the application key
echo "Setting up environment file and generating application key..."
cp .env.example .env
./vendor/bin/sail artisan key:generate

# Step 4: Run migrations and seed the database
echo "Running migrations and seeding the database..."
./vendor/bin/sail artisan migrate --seed

# Step 5: Build front-end assets
echo "Building front-end assets..."
./vendor/bin/sail npm run build

./vendor/bin/sail up -d

echo "Setup process completed successfully!"
