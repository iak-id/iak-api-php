<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotEnv = Dotenv::createMutable(__DIR__);
$dotEnv->load();