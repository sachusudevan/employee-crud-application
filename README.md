git clone https://github.com/sachusudevan/employee-crud-application.git

cd .\employee-crud-application\

composer install

rename ".env.example" in to "env" file

configure database credentials in env file

please setup email configuration in ".env" file

php artisan key:generate

php artisan storage:link

php artisan migrate:fresh --seed

php artisan serve --host=0.0.0.0 --port=8000