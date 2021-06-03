# API PHP SDK - IAK
![php version requirement](https://img.shields.io/badge/php%20version-%3E=%205.6-red)
PHP library to help you integrate your system to Indobest Artha Kreasi (IAK) API services. This library consists of two sections, **prepaid** and **postpaid**

# Installation
Using Composer
```
composer require iak-id/iak-api-php
```

**Note**: Parameter used in IAK API's functions is in the form of single **array** parameter which consists of zero or multiple available field(s)

# Configuration
## Parameter Passing
Passing your IAK API configuration as parameters when creating an IAK instance in your project.

Available fields
- userHp ---> your registered phone number in IAK [required]
- apiKey ---> your development or production API key in IAK [required]
- stage ---> "sandbox" or "production" [default: sandbox]

Code Example
- Prepaid
```php
$iakPrepaid = new IAKPrepaid([
    'userHp' => '0813********',
    'apiKey' => 'e8g32*******',
    'stage' => 'sandbox'
]);
```
- Postpaid
```php
$iakPostpaid = new IAKPostpaid([
    'userHp' => '0813********',
    'apiKey' => 'e8g32*******',
    'stage' => 'sandbox'
]);
```

## PHP Dot Env
When creating an IAK instance, parameter passing can be ignored by configuring your IAK API credentials manually.
1. Create .env file in your root project
2. Define necessary key(s) to replace parameter field(s)
3. Available keys:
    - IAK_USERHP ---> replace userHp field
    - IAK_APIKEY_SANDBOX ---> replace apiKey field if stage is **sandbox**
    - IAK_APIKEY_PRODUCTION ---> replace apiKey field if stage is **production**
    - IAK_STAGE ---> replace stage field

.env Example
```
IAK_USERHP=0813********
IAK_APIKEY_SANDBOX=e8g32*******
IAK_APIKEY_PRODUCTION=as342******
IAK_STAGE=sandbox
```
**Note: These keys also serve as default value if some field(s) is not available when creating an IAK instance**

Code example without parameter passing
```php
$iakPrepaid = new IAKPrepaid();
```

Code example with incomplete parameter
```php
$iakPostpaid = new IAKPostpaid([
    'stage' => 'production'
]);
```
In this case, **stage** value in parameter will override IAK_STAGE value in .env
