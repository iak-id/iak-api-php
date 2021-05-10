<?php

use IakID\IakApiPHP\Services\IAKPrepaid;

require 'vendor/autoload.php';

$iak = new IAKPrepaid([
    'userHp' => '081368433358',
    'apiKey' => '3215ee6f585a12fa',
    'stage' => 'sandbox'
]);

echo $iak->checkBalance();