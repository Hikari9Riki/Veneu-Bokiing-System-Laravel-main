#!/bin/bash

echo "=== Laravel Setup Script ==="
echo ""

# Copy .env safely
if [ ! -f .env ]; then
  cp .env.example .env
  echo ".env file created."
else
  echo ".env file already exists. Skipping copy."
fi

echo ""
echo "IMPORTANT:"
echo "Please edit the .env file and configure your database settings."
echo "Remove the # symbol and set the correct values:"
echo ""
echo "DB_CONNECTION=mysql"
echo "DB_HOST=127.0.0.1"
echo "DB_PORT=3306"
echo "DB_DATABASE=laravel"
echo "DB_USERNAME=root"
echo "DB_PASSWORD="
echo ""

echo "Windows (PowerShell) users may use:"
echo "# (Get-Content .env) -replace '# DB_CONNECTION=.*', 'DB_CONNECTION=mysql'"
echo "# (Get-Content .env) -replace '# DB_HOST=.*', 'DB_HOST=127.0.0.1'"
echo "# (Get-Content .env) -replace '# DB_PORT=.*', 'DB_PORT=3306'"
echo "# (Get-Content .env) -replace '# DB_DATABASE=.*', 'DB_DATABASE=laravel'"
echo "# (Get-Content .env) -replace '# DB_USERNAME=.*', 'DB_USERNAME=root'"
echo "# (Get-Content .env) -replace '# DB_PASSWORD=.*', 'DB_PASSWORD='"
echo ""

read -n 1 -s -r -p "Press any key to continue after editing .env..."
echo ""

echo ""
echo "Installing PHP dependencies..."
composer install

echo ""
echo "Generating application key..."
php artisan key:generate

echo ""
echo "Running database migrations (SAFE MODE)..."
php artisan migrate

echo ""
echo "Running database seed (SAFE MODE)..."
php artisan db:seed

echo ""
echo "Installing NPM dependencies..."
npm install

echo ""
echo "Setup complete!"
echo "Run: php artisan serve"