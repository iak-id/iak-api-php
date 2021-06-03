# API PHP SDK - IAK
![php version requirement](https://img.shields.io/badge/php%20version-%3E=%205.6-red)

PHP library to help you integrate your system to Indobest Artha Kreasi (IAK) API services. This library consists of two sections, **prepaid** and **postpaid**

**Note**: 
- Parameter used in IAK API's functions is in the form of single **array** parameter which consists of zero or multiple available field(s)
- Response given by each function is in the form of a single **array**. Please refer to each section's response example for more details

# Installation
Using Composer
```
composer require iak-id/iak-api-php
```

# Getting Started
We will start things off with configuring IAK API credential which is required to use IAK API features. There are two ways to configure your API credential, pass your credential as parameter or set your initial credential in env file.
## Parameter Passing
Passing your IAK API configuration as parameters when creating an IAK instance in your project.

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| userHp | Your registered phone number in IAK | Yes | - |
| apiKey | Your development or production API key in IAK | Yes | - |
| Stage | "sandbox" or "production" | Yes | sandbox |

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
    - IAK_USERHP --> Replace userHp field
    - IAK_APIKEY_SANDBOX --> Replace apiKey field if stage is **sandbox**
    - IAK_APIKEY_PRODUCTION --> Replace apiKey field if stage is **production**
    - IAK_STAGE --> Replace stage field

.env Example
```
IAK_USERHP=0813********
IAK_APIKEY_SANDBOX=e8g32*******
IAK_APIKEY_PRODUCTION=as342******
IAK_STAGE=sandbox
```
**Note: These keys also serve as default value if some field(s) are not available when creating an IAK instance**

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

# Prepaid
## Check Balance
API for checking your deposit balance

Check balance function doesn't require any parameter to pass

Code Example
```php
$iakPrepaid = new IAKPrepaid();
echo $iakPrepaid->checkBalance();
```
Response Example
```php
[
    'data' => [
        'balance' => 100000000,
        'message' => 'SUCCESS',
        'rc' => '00'
    ]
]
```

## Check Status
API for checking your prepaid transaction status

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| refId | Your order number / reference ID | Yes | - |

Code Example
```php
$iakPrepaid = new IAKPrepaid();
echo $iakPrepaid->checkStatus([
    'refId' => '123'
]);
```
Response Example
```php
[
    'data' => [
        'ref_id' => '123',
        'status' => 1,
        'product_code' => 'htelkomsel10000',
        'customer_id' => '081357922222',
        'price' => 10850,
        'message' => 'SUCCESS',
        'balance' => '99989150',
        'tr_id' => 1,
        'rc' => '00',
        'sn' => '123456789'
    ]
]
```

## Pricelist
API for generating prepaid products' pricelist

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| type | Product type. See [here](https://api.iak.id/docs/reference/docs/prepaid/product-type.md) for product type list | No | - |
| operator | Operator type. See [here](https://api.iak.id/docs/reference/docs/prepaid/product-type.md) for operator type list | No | - |
| status | Product Status. "all", "active", "non active" | No | all |

Code Example
```php
$iakPrepaid = new IAKPrepaid();
echo $iakPrepaid->pricelist([
    'type' => 'pulsa'
    'status' => 'all'
]);
```
Response Example
```php
[
    'data' => [
        [
            'product_code' => 'alfamart100',
            'product_description' => 'Alfamart Voucher',
            'product_nominal' => 'Voucher Alfamart Rp 100.000',
            'product_details' => '-',
            'product_price' => 100000,
            'product_type' => 'voucher',
            'active_period' => '0',
            'status' => 'active',
            'icon_url' => 'http=>//cdn.mobileproduct.net/img/product/operator_list/140119034649-Alfa-01.png'
        ],
        [
            'product_code' => 'altel10',
            'product_description' => 'Malaysia Topup',
            'product_nominal' => '10',
            'product_details' => '-',
            'product_price' => 39750,
            'product_type' => 'malaysia',
            'active_period' => '0',
            'status' => 'active',
            'icon_url' => '-'
        ]
    ]
]
```

## Top Up
API for top up prepaid transaction e.g. pulsa, e-money, voucher, game voucher

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| customerId | Customer ID / phone number | Yes | - |
| refId | Your order number / reference ID (Must Unique) | Yes | - |
| productCode | Product Code. See full list [here](https://iak.id/webapp/pricelist) or in Pricelist API | Yes | - |

Code Example
```php
$iakPrepaid = new IAKPrepaid();
echo $iakPrepaid->topUp([
    'customerId' => '081357922222',
    'refId' => '123',
    'productCode' => 'htelkomsel10000'
]);
```
Response Example
```php
[
    'data' => [
        'ref_id' => '123',
        'status' => 0,
        'product_code' => 'htelkomsel10000',
        'customer_id' => '081357922222',
        'price' => 10850,
        'message' => 'PROCESS',
        'balance' => '99989150',
        'tr_id' => 1,
        'rc' => '39'
    ]
]
```

## Inquiry
Inquiry prepaid consists of inquiry game id, inquiry game server, and inquiry PLN

### Inquiry Game ID
API for checking availability of an ID in a game

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| customerId | Customer ID. See [here](https://api.iak.id/docs/reference/docs/prepaid/game-format.md) for customer ID | Yes | - |
| gameCode | Game Code. See [here](https://api.iak.id/docs/reference/docs/prepaid/game-format.md) for game code list | Yes | - |

Code Example
```php
$iakPrepaid = new IAKPrepaid();
echo $iakPrepaid->inquiryGameID([
    'customerId' => '156378300|8483',
    'gameCode' => '103'
]);
```
Response Example
```php
[
    'data' => [
        'username' => 'budi',
        'status' => 1,
        'message' => 'SUCCESS',
        'rc' => '00'
    ]
]
```

### Inquiry Game Server
API for generating game server list

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| gameCode | Game Code. See [here](https://api.iak.id/docs/reference/docs/prepaid/game-format.md) for game code list | Yes | - |

Code Example
```php
$iakPrepaid = new IAKPrepaid();
echo $iakPrepaid->inquiryGameServer([
    'gameCode' => '142'
]);
```
Response Example
```php
[
    'data' => [
        'servers' => [
            [
                'name' => 'Test 1',
                'value' => '90001'
            ],
            [
                'name' => 'Test 2',
                'value' => '90002'
            ]
        ],
        'status' => 1,
        'message' => 'SUCCESS',
        'rc' => '00'
    ]
]
```

### Inquiry PLN / Electricity
API for checking whether PLN Prepaid Subscriber is valid or invalid

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| customerId | Customer ID | Yes | - |

Code Example
```php
$iakPrepaid = new IAKPrepaid();
echo $iakPrepaid->inquiryPLN([
    'customerId' => '12345678901'
]);
```
Response Example
```php
[
    'data' => [
        'status' => 1,
        'customer_id' => '12345678901',
        'meter_no' => '548933889287',
        'subscriber_id' => '12345678901',
        'name' => 'Test PLN',
        'segment_power' => 'R1M /000000900',
        'message' => 'SUCCESS',
        'rc' => '00'
    ]
]
```

# Postpaid
## Check Status
API for checking your postpaid transaction status

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| refId | Your order number / reference ID (Must Unique) | Yes | - |

Code Example
```php
$iakPostpaid = new IAKPostpaid();
echo $iakPostpaid->checkStatus([
    'refId' => '123'
]);
```
Response Example
```php
[
    'data' => [
        'tr_id' => 1,
        'code' => 'PDAM',
        'datetime' => '20180803171608',
        'hp' => '08123123123',
        'tr_name' => 'Test',
        'period' => '202105,202106',
        'nominal' => 120000,
        'admin' => 7500,
        'ref_id' => '123',
        'status' => 0,
        'response_code' => '00',
        'message' => 'PAYMENT SUCCESS',
        'price' => 127500,
        'selling_price' => 126000,
        'balance' => 981230000,
        'desc' => []
    ],
    'meta' => []
]
```

## Pricelist
API for generating postpaid products' pricelist

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| type | Product type. See [here](https://api.iak.id/docs/reference/docs/postpaid/core/price-list.md) for product type list | No | - |
| province | 34 Provinces in Indonesia (Only for PDAM type) | No | - |
| status | Product Status. "all", "active", "non active" | No | all |

Code Example
```php
$iakPostpaid = new IAKPostpaid();
echo $iakPostpaid->pricelist([
    'type' => 'pdam',
    'status' => 'all'
]);
```
Response Example
```php
[
    'data' => [
        'pasca' => [
            [
                'code' => 'AETRA',
                'name' => 'AETRA',
                'status' => 1,
                'fee' => 2500,
                'komisi' => 700,
                'type' => 'pdam'
            ]
        ]
    ],
    'meta' => []
]
```

## Inquiry
API for inquiry postpaid product

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| code | Product code. See [here](https://iak.id/webapp/pricelist) or Pricelist API for product code list | Yes | - |
| hp | Customer number | Yes | - |
| refId | Your order number / reference ID (Must Unique) | Yes | - |
| month | Number of month you're willing to pay (Required for BPJS type) | No | - |

Code Example
```php
$iakPostpaid = new IAKPostpaid();
echo $iakPostpaid->inquiry([
    'code' => 'BPJS',
    'hp' => '8801234560001',
    'refId' => '123',
    'month' => 2
]);
```
Response Example
```php
[
    'data' => [
        'tr_id' => 1,
        'code' => 'BPJS',
        'hp' => '8801234560001',
        'tr_name' => 'Test',
        'period' => '02',
        'nominal' => 50000,
        'admin' => 2500,
        'ref_id' => '123',
        'response_code' => '00',
        'message' => 'INQUIRY SUCCESS',
        'price' => 52500,
        'selling_price' => 52300,
        'desc' => [
            'kode_cabang' => '0901',
            'nama_cabang' => 'JAKARTA PUSAT',
            'sisa_pembayaran' => '0',
            'jumlah_peserta' => '2'
        ]
    ],
    'meta' => []
]
```

## Payment
API for paying postpaid product

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| trId | Transaction ID | Yes | - |

Code Example
```php
$iakPostpaid = new IAKPostpaid();
echo $iakPostpaid->payment([
    'trId' => 1
]);
```
Response Example
```php
[
    'data' => [
        'tr_id' => 1,
        'code' => 'BPJS',
        'datetime' => '20180803170750',
        'hp' => '8801234560001',
        'tr_name' => 'Test',
        'period' => '202105',
        'nominal' => 50000,
        'admin' => 2500,
        'response_code' => '00',
        'message' => 'PAYMENT SUCCESS',
        'price' => 52500,
        'selling_price' => 52300,
        'balance' => 999490800,
        'noref' => '148732328035714773',
        'ref_id' => '123',
        'desc' => [
            'kode_cabang' => '0901',
            'nama_cabang' => 'JAKARTA PUSAT',
            'sisa_pembayaran' => '0',
            'jumlah_peserta' => '2'
        ]
    ],
    'meta' => []
]
```

## Download Receipt
API for retrieving paid transaction's receipt details

Available fields
| Field Name | Description | Mandatory | Default Value |
|---|---|---|---|
| trId | Transaction ID | Yes | - |

Code Example
```php
$iakPostpaid = new IAKPostpaid();
echo $iakPostpaid->downloadBill([
    'trId' => 1
]);
```
Response Example
```php
[
    'data' => [
        'HEADER' => 'STRUK PEMBAYARAN BPJS Kesehatan',
        'NO REFERENSI' => '148732328035714773',
        'TANGGAL' => '2021-05-27 18:56:01',
        'NO. RESI' => '148732328035714773',
        'NAMA PRODUK' => 'BPJS Kesehatan',
        'JUMLAH PESERTA' => '2 ORANG',
        'SISA SBLMNYA' => 'Rp 0',
        'PERIODE' => '2 BULAN',
        'ID PELANGGAN' => '8801234560001',
        'NAMA' => 'Test',
        'JUMLAH TAGIHAN' => 'Rp 50.000',
        'ADMIN' => 'Rp 2.500'
    ]
]
```

# Response Code
See [here](https://api.iak.id/docs/reference/docs/prepaid/response-code.md) for prepaid response code list

See [here](https://api.iak.id/docs/reference/docs/postpaid/response-code.md) for postpaid response code list


# Error Handling
If error occured or HTTP status code from API call is **not** 200, exception will be thrown with error message included.
Several cases where exception might be thrown
- Passing Parameter type is not an array (InvalidContentType)
- Missing / Incomplete field(s) in passing parameter (MissingArguements)
- Timeout API call and other errors thrown by API call (IAKException)
- Undefined error (UndefinedError)
