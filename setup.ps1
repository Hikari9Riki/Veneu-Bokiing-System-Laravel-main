cp .env.example .env
echo ""
echo "find and replace DB settings in .env file" 
echo "remove the # symbol from the DB settings"
echo "set DB_CONNECTION to mysql"
echo ""
echo "
# You can uncomment below lines to set DB settings via PowerShell
# (Get-Content .env) -replace '# DB_CONNECTION=.*', 'DB_CONNECTION=mysql
# (Get-Content .env) -replace '# DB_HOST=.*', 'DB_HOST=
# (Get-Content .env) -replace '# DB_PORT=.*', 'DB_PORT=3306'
# (Get-Content .env) -replace '# DB_DATABASE=.*', 'DB_DATABASE=laravel'
# (Get-Content .env) -replace '# DB_USERNAME=.*', 'DB
# (Get-Content .env) -replace '# DB_PASSWORD=.*', 'DB_PASSWORD='
"
echo ""
echo "change first before continue..."
echo "Press any key to continue..."
echo ""
Pause
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed  
npm install
echo "try to run php artisan serve to start the server"

