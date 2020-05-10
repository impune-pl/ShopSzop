Simplified web store written in Laravel and Vue.
Pre-requirements:  
This application is configured to use postgresql as database server. If you are using different server, 
you have to edit lines starting with ```DB_``` in ```.env``` file.

  
To run:
1. put it in your laravel directory
2. Execute following commands in project root directory  
```
php artisan migrate
php artisan passport:install  
php artisan db:seed
npm install
```
3. If you are not using laravel homestead vagrant virtual machine, you will probably need to execute ```php artisan serve```


For testing:
```/telescope/``` - contains laravel debugging/monitoring tool for you to use  
Any notifications that you try to send from admin panel, will end up in log section in telescope, unless you configure
 ```/config/mail.php``` and ```.env``` to use email server and account.
 
The application has a few built-in users:  
Administrator account - username: admin, mail: admin@mail.local, password: 1234admin  
User account - username: user, mail: user@mail.local, password: 1234user  
Test account - username: test, mail: test@mail.local, password: 1234test - banned by default.  


Have fun!
