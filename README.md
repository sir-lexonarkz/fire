# FIRe Feeds Importer & Reader
Demo example Symfony 7.1 with Symfony UX components (UX Live components, UX Swup, UX icons)

## Usage
Add sources with RSS XLM URL and click refresh button to import content in database

## Installation
```shell
# Install required dependencies
$ composer install
$ npm install

# Create database and schema
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
```

## Resources
- [Install Symfony UX](https://symfony.com/doc/current/frontend/ux.html).
- [List of UX Packages](https://symfony.com/bundles/StimulusBundle/current/index.html#the-ux-packages).
- [Symfony UX Official Demo](https://ux.symfony.com).