<?php

$dir = __DIR__;
include 'src/Base/Base.php';
$request = \Base\BaseApp::request();

$legacy = false;
if (!$providerId = $request->filter('_baseProvider', 'str'))
{
	$providerId = 'PayPal';
	$legacy = true;
}

$provider = \Base\BaseApp::getPayment($providerId);
/** @var \Base\Payment\AbstractProvider $handler */
$handler = $provider->getPaymentHandler();
$state = $handler->setupCallback($request);
$state->legacy = $legacy;
if($handler->validateCallback($state)
    && $handler->validateTransaction($state)
    && $handler->validatePurchasableData($state)
    && $handler->validateCost($state)
    && $handler->validatePurchaseRequest($state)
    && $handler->validatePurchasableHandler($state)
    && $handler->validatePaymentProfile($state)
    && $handler->validatePurchaser($state))
{
    $handler->setProviderMetadata($state);
    $handler->getPaymentResult($state);
    $handler->completeTransaction($state);
}


if ($state->logType)
{
    $handler->log($state);
}