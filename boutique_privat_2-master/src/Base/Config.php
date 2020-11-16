<?php

$config['db'] = [
    'host' => 'localhost',
    'port' => '3306',
    'username' => 'root',
    'password' => '',
    'dbname' => 'boutique',
];
$config['option']['useFriendlyUrls'] = true;
$config['option']['defaultNameSite'] = 'Dev Soluce';
$config['option']['timeZone'] = 'Europe/Paris';
$config['option']['debug'] = true;
$config['option']['SessionUserId'] = 'user_id';
$config['option']['user_id'] = 'user_id';
$config['option']['AccountPayPal'] = 'paypal-facifil20@crystalcommunity.io';
$config['option']['baseUrl'] = 'http://dev-boutique.crystalcommunity.io/';
$config['option']['purchasable'] = [
    'product' => 'App:Product'
];
$config['option']['defaultSaleTaxRate'] = 20.000;
$config['option']['limitMaxByPage'] = 500;