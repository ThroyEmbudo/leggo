# Leggo

This simple system contains weather forecast and few places to visit on JAPAN depending what the user has chosen. Leggo system is mobile ready system and already following the best practices for Vue3. Code implementation for laravel are already following the PHP Standard Recommendation. 

###Quick Summary for each Page

### Home 
Contains the fewer details for Weather forecast and Places. The details shown depends on the user's choice for the city. 

### Forecast 
Contains the details for the whole week for the Weather Forecast. The details shown depends on the user's choice for the city.

### Places 
List the places near the City the user choose. Also, it filters the list depending on the Category the user inputted. 

## Installation 

This installation assumes that PHP, Composer and Nodejs is already installed on your system. If all 3 are not installed, check the link below for steps. 

### PHP and Composer Installation (Windows Only)
```
https://devanswers.co/install-composer-php-windows-10/
```

### NodeJs Installation
```
https://radixweb.com/blog/installing-npm-and-nodejs-on-windows-and-mac
```
Assuming PHP, Composer and NodeJs are installed you can follow the command line below. 

### WEB  Installation 
```
cd WEB\src\
npm install 
npx quasar dev
```

### API Installation 
```
cd API
composer install
php artisan serve
```

To run quasar again, go to `WEB\src` and run `npx quasar dev` in command line. 

To run laravel API again, go to `API` and run `php artisan serve` in command line. 

Enjoy! 



