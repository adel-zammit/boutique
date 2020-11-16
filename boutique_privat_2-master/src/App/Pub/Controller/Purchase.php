<?php
namespace App\Pub\Controller;

use Base\Purchasable\Purchasable;
use Base\BaseApp;
use Base\Mvc\ParameterBag;
use Base\Purchasable\AbstractPurchasable;

/**
 * Class Purchase
 * @package App\Pub\Controller
 */
class Purchase extends AbstractController
{
    /**
     * @param ParameterBag $params
     * @return mixed
     * @throws \Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        $purchasable = $this->assertPurchasableExists($params->purchasable_type_id);

        /** @var AbstractPurchasable $purchasableHandler */
        $purchasableHandler = $purchasable->getHandler();
        $purchase = $purchasableHandler->getPurchaseFromRequest(BaseApp::request(), BaseApp::visitor(), $error);

        $purchaseRequest = $purchasable->insertPurchaseRequest($purchase);

        $providerHandler = $purchase->paymentProfile->getPaymentHandler();
        return $providerHandler->initiatePayment($this, $purchaseRequest, $purchase);
    }

    /**
     * @param $id
     * @return Purchasable
     */
    protected function assertPurchasableExists($id)
    {
        return BaseApp::getPurchasable($id);
    }
}