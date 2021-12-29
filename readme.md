# Crypto currencies courses.
#### Version 1.0b
#### Author: Vitalii Minenko

A simple application which will show courses of most popular Crypto currency.

##### Haw we can start the application.
For start application you must have min PHP 7.3.0 and Node JS min 16.0.0

* Main point for application this is public_html folder.

```
"C:/xampp/htdocs/test.local/public"
```

* When you are in a public_html folder, type the command php -S localhost:3000 in the command line and you can check application in your browser at address localhost:3000.
```
php -S localhost:3000
```
* Or you can setup application at webserver like Apache, below you can find example haw to configurate Apache Virtual Host.
```
<VirtualHost *:80>
    ServerAdmin vitaliyminenko@mail.ru
    DocumentRoot "C:/xampp/htdocs/test.local/public"
    ServerName test.local
    ##ErrorLog "logs/test.local.log"
    ##CustomLog "logs/test.local.log" common
</VirtualHost>

``` 
If application start successfully you should install all dependencies and setup config files.
* Copy .env.example and paste with name .env and setup all necessary fields.



* Run next commands at the console.
```
npm install
composer install
``` 

* Now application is ready and you can use it. Please enjoy ;)


For application was prepared couple API test.

At the config file tests/api.suite.yml we should set url which we use for our application. For example if we use localhost:3000
```
url: http://localhost:3000/api/v1/
```

After that we can start tests by next command.

```
php vendor/bin/codecept run api

``` 
