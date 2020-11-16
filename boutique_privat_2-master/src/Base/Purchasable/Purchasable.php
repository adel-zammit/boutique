<?php


namespace Base\Purchasable;


use Base\Entity\PurchaseRequest;
use Base\Purchasable\Purchase;
use Base\BaseApp;
use Base\Mvc\Controller;

class Purchasable
{
    protected $classString;
    protected $purchasableTypeId;

    /**
     * Purchasable constructor.
     * @param $classSting
     * @param $purchasableTypeId
     */
    public function __construct( $classSting, $purchasableTypeId)
    {
        $this->classString = $classSting;
        $this->purchasableTypeId = $purchasableTypeId;
    }

    /**
     * @return mixed
     */
    public function getClassSting()
    {
        return $this->classString;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return BaseApp::stringToClass($this->classString, '%s\Purchasable\%s');
    }

    /**
     * @return mixed|null
     */
    public function getHandler()
    {
        $class = $this->getClass();
        if (!class_exists($class))
        {
            return null;
        }

        return new $class($this->purchasableTypeId);
    }

    /**
     * @param \Base\Purchasable\Purchase $purchase
     * @return PurchaseRequest
     * @throws \Exception
     */
    public function insertPurchaseRequest(Purchase $purchase)
    {
        /** @var PurchaseRequest $purchaseRequest */
        $purchaseRequest = BaseApp::create('Base:PurchaseRequest');

        $purchaseRequest->request_key = $this->generateRequestKey();
        $purchaseRequest->user_id = $purchase->purchaser->{BaseApp::getConfigOptions()->user_id};
        $purchaseRequest->provider_id = $purchase->paymentProfile->getPaymentString();
        $purchaseRequest->purchasable_type_id = $purchase->purchasableTypeId;
        $purchaseRequest->cost_amount = $purchase->cost;
        $purchaseRequest->cost_currency = $purchase->currency;
        $purchaseRequest->extra_data = $purchase->extraData;

        $purchaseRequest->save();

        return $purchaseRequest;
    }

    /**
     * @return false|string
     * @throws \Exception
     */
    public function generateRequestKey()
    {
        $finder = BaseApp::finder('Base:PurchaseRequest');

        do
        {
            $requestKey = \Base\Util\Random::getRandomString(32);

            $found = $finder
                ->where('request_key', $requestKey)
                ->fetchOne();

            if (!$found)
            {
                break;
            }
        }
        while (true);

        return $requestKey;
    }
}