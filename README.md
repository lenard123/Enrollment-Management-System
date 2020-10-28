### Installation

1. Run the following commands
``
git clone https://github.com/lenard123/Enrollment-Management-System
cd Enrollment-Management-System
composer install
php artisan storage:link


2. Rename .env.example -> .env and setup your database
3. Run 'php artisan migrate --seed'
4. Run 'php artisan passport:install'
5. Run 'php artisan key:generate'
6. Run 'php artisan serve'


