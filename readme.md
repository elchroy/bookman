# Bookman Web Service

[![Build Status](https://travis-ci.org/elchroy/bookman.svg?branch=master)](https://travis-ci.org/elchroy/bookman) [![Coverage Status](https://coveralls.io/repos/github/elchroy/bookman/badge.svg?branch=master)](https://coveralls.io/github/elchroy/bookman?branch=master) [![StyleCI](https://styleci.io/repos/110004543/shield?branch=master)](https://styleci.io/repos/110004543)

### Bookman is a web service that makes it easy for users to manage their bookman resources, which are mainly _books_.
- ##### It an XML based SOAP web service.
- ##### Built with PHP using the [Lumen framework](http://lumen.laravel.com/docs)
- ##### PostgreSQL database

## API Documentation and Usage
- Visit this [link](https://bookman.docs.apiary.io/#) to view the API documentation.

## Requirements
- PHP 7.1+
- Composer
- PostgreSQL

## Installation
- Clone this repository
- Install dependencies - `composer install`. _**Note that PHP SOAP extension is required for installation.**_
- Start the server - `php -S localhost:8000 -t public`

## Testing
This project uses [PHPUnit](https://phpunit.de) to Unit testing.
- Run `phpunit` to run tests.
- You might have to run `./vendor/bin/phpunit` if you don't have PHPUnit installed globally.
- 

## Security Vulnerabilities

If you discover a security vulnerability while using the service Lumen, please create an issue in this repository. Or submit a pull request to fix the issue. It would be reveiwed in time, and possible merged in.

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
