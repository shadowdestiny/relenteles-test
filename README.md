# Relentless REST-API

Un ejemplo de RESTful API creado con Laravel Lumen.

## Pre-requisitos

1) This RESTful API was created with [Laravel Lumen] (https://lumen.laravel.com/), which requires a modern version of PHP and some of its extensions installed

```
PHP >= 7.2.0
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
XML PHP Extension
```

1) You can install a client to test all the *end-points*. 

[Postman](https://www.getpostman.com/) 
Repository located in: `<REPO>/lmarin/Project Test API.postman_collection`.


## Installation for Development

1) Install Composer dependencies (run from the root directory of this project).
```
composer install
```
2) Configure database:

You just have to run the following command
```
php artisan migrate:refresh --seed
```
2.3) The file called `.env` at the root of this project should have the following characteristics, with the following data:
```
APP_NAME=Relentless
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3060
DB_DATABASE=relentless
DB_USERNAME=root
DB_PASSWORD=mypassword

CACHE_DRIVER=file
QUEUE_CONNECTION=sync

REDIS_HOST=192.168.99.100
REDIS_PASSWORD=null
REDIS_PORT=32782
```

3) Start your server at port 8085
```
php -S localhost:8085 -t public
```

4) To handle the use of cache in the query query, you have to install redis as a doker container and pass the ports in the .env



## Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

### Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

### Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
