# API PHP SDK - IAK
![php version requirement](https://img.shields.io/badge/php%20version-%3E=%205.6-red)

PHP library to help you integrate your system to Indobest Artha Kreasi (IAK) API services. This library consists of two sections, **prepaid** and **postpaid**

**Note**: 
- You have to register yourself first on this [link](https://iak.id) to get the access key for our API services
- Parameter used in IAK API's functions is in the form of single **array** parameter which consists of zero or multiple available field(s)
- Response given by each function is in the form of a single **array**. Please refer to each section's response example for more details

## Installation
Using Composer

```php
composer require iak-id/iak-api-php
```

## Getting Started
You can use below snippet code to use our check balance service on prepaid API and get our pricelist on postpaid API to get started on our SDK.

### Prepaid

```php
<?php
// import autoload
require_once __DIR__ . "/vendor/autoload.php";

use IakID\IakApiPHP\IAK;

$iak = new IAK([
    'userHp' => 'your-username',
    'apiKey' => 'your-api-key-depending-on-stage',
    'stage' => 'sandbox-or-production'
]);

$prepaid = $iak->PrePaid();

echo '<pre>';
print_r($prepaid->checkBalance());
echo '</pre>';
```

### Postpaid
```php
<?php
// import autoload
require_once __DIR__ . "/vendor/autoload.php";

use IakID\IakApiPHP\IAK;

$iak = new IAK([
    'userHp' => 'your-username',
    'apiKey' => 'your-api-key-depending-on-stage',
    'stage' => 'sandbox-or-production'
]);

$postpaid = $iak->PostPaid();

echo '<pre>';
print_r($postpaid->pricelist());
echo '</pre>';

```

### Callback
```php
<?php
// import autoload
require __DIR__ . '/vendor/autoload.php';

use IakID\IakApiPHP\IAK;

$iak = new IAK([
    'userHp' => 'your-username',
    'apiKey' => 'your-api-key-depending-on-stage',
    'stage' => 'sandbox-or-production'
]);

$init = $iak->initCallback();


if ($init->validateSignature() && $init->validateIPNotifications()) {
    file_put_contents(__DIR__ . '/callback.json', $init->get() . PHP_EOL . PHP_EOL, FILE_APPEND | LOCK_EX);
} else {
    file_put_contents(__DIR__ . '/callback.json', 'Sign :' . $init->validateSignature() . 'IP :' . $init->validateIPNotifications() . PHP_EOL . PHP_EOL, FILE_APPEND | LOCK_EX);
}

```

## Documentation
You can find the documentation of this package at [API SDK docs](https://api.iak.id/docs/sdk/docs/php/introduction.md)


## Changelog
See [CHANGELOG](https://api.iak.id/docs/sdk/docs/php/changelog.md) for more information on what has changed recently


## Contributing
You can contribute on the development of this package by [opening new issue(s)](https://github.com/iak-id/iak-api-php/issues) when encountering any bugs or issues in this project or by [submitting new pull request(s)](https://github.com/iak-id/iak-api-php/pulls) to contribute directly to the code
