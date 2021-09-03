<?php

require 'vendor/autoload.php';


// import IAKPrepaid Class
use IakID\IakApiPHP\IAK;

$iak = new IAK([
    'userHp' => 'your-username',
    'apiKey' => 'your-api-key-depending-on-stage',
    'stage' => 'sandbox-or-production'
]);

$postpaid = $iak->PostPaid();
$prepaid = $iak->Prepaid();


echo '<pre>';
var_dump($prepaid);
echo '</pre>';
