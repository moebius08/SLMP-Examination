#!/bin/sh
set -e

# Generate application key if not already set
php artisan key:generate --force

echo "Running migrations..."
# Since this is dev environment, We can force the migrations
php artisan migrate --force

# Run the JSON placeholder data fetch
echo "Fetching JSON placeholder data..."
php artisan fetch:jsonplaceholder

# Start the application
echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0