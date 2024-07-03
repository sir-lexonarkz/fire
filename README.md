# FIRe Feeds Importer & Reader
Demo example Symfony 7.1 with Symfony UX components (UX Live components, UX Swup, UX icons) and API Platform

## Usage
- Add sources with RSS XLM URL and click refresh button to import content in database
- Access to API documentation API Plateform : /api

## Installation
```shell
# Install required dependencies
$ composer install
$ npm install

# Create database and schema
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
```

## Requirements
- PHP 8.3.*
- MySQL, SQLite or PostgreSQL
- [Apache or Symfony server](https://symfony.com/doc/current/setup/symfony_server.html) 
- [NPM, NodeJS](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [Composer](https://getcomposer.org/)

## Test tools
- PHPUnit
```shell
$ php bin/phpunit
```
- PHPStan
```shell
$ php vendor/bin/phpstan
```
- Behat
```shell
$ php vendor/bin/behat
```

## Resources
- [Install Symfony UX](https://symfony.com/doc/current/frontend/ux.html).
- [List of UX Packages](https://symfony.com/bundles/StimulusBundle/current/index.html#the-ux-packages).
- [Symfony UX Official Demo](https://ux.symfony.com).
- [Behat API Extension](https://behat-api-extension.readthedocs.io/en/latest/)
- [API Platform](https://api-platform.com/)