#!/bin/bash

echo "Running tests..."

# Run PHPUnit tests using Sail
./vendor/bin/sail artisan test

echo "Tests completed!"