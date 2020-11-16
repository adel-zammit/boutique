<?php


namespace App\Purchasable;

use App\Entity\Coupon;
use App\Entity\CouponLog;
use App\Entity\Invoices;
use App\Entity\ItemsPurchased;
use App\Entity\Products;
use App\Entity\User;
use Base\Payment\CallbackState;
use Base\Purchasable\Purchase;
use Base\App;
use Base\BaseApp;
use Base\Purchasable\AbstractPurchasable;

class Product extends AbstractPurchasable
{
    public function getTitle()
    {
        return 'buy product';
    }

    public function getPurchaseFromRequest(\Base\Request $request, User $purchaser, &$error = null)
    {

        $profileId = $request->filter('payment_profile_id', 'str');

        $paymentProfile = BaseApp::getPayment($profileId);
        $invoiceId = $request->filter('invoice_id', 'uint');
        $invoice = BaseApp::find('App:Invoices', $invoiceId);
        return $this->getPurchaseObject($paymentProfile, $invoice, $purchaser);
    }

    public function getPurchasableFromExtraData(array $extraData)
    {
        $output = [
            'link' => '',
            'title' => '',
            'purchasable' => null
        ];
        /** @var Invoices $invoice */
        $invoice = BaseApp::find('App:Invoices', $extraData['invoice_id']);
        if($invoice)
        {
            $output['link'] = BaseApp::newApp('Admin')->buildLink('admin:log/order', $invoice);
            $output['title'] = 'Product order' . ' #' . $invoice->invoice_id;
            $output['purchasable'] = $invoice;
        }
        return $output;
    }

    public function getPurchaseFromExtraData(array $extraData,  $paymentProfile, User $purchaser, &$error = null)
    {
        $invoice = $this->getPurchasableFromExtraData($extraData);

        return $this->getPurchaseObject($paymentProfile, $invoice['purchasable'], $purchaser);
    }


    public function getPurchaseObject($paymentProfile, $purchasable, User $purchaser)
    {
        $purchase = new Purchase();

        $purchase->title =  'Invoice id: #' . $purchasable->invoice_id . ' (' .  $purchaser->username . ')';
        $purchase->description =  implode(', ', $purchasable->getProductList());
        $purchase->cost = $purchasable->total_price;
        $purchase->currency = 'EUR';
        $purchase->purchaser = $purchaser;
        $purchase->paymentProfile = $paymentProfile;
        $purchase->purchasableTypeId = $this->purchasableTypeId;
        $purchase->purchasableId = 1;
        $purchase->purchasableTitle = 'Invoice id: #' . $purchasable->invoice_id;
        $purchase->extraData = [
            'invoice_id' => $purchasable->invoice_id
        ];
        $purchase->returnUrl = $purchasable->getBaseUrl();
        $purchase->cancelUrl = $purchasable->getBaseUrl();

        return $purchase;
    }

    public function completePurchase(CallbackState $state)
    {
        $purchaseRequest = $state->getPurchaseRequest();
        $hasOrderRecord = isset($purchaseRequest->extra_data['invoice_record'])
            ? $purchaseRequest->extra_data['order_record']
            : null;
        $invoiceId = $purchaseRequest->extra_data['invoice_id'];
        /** @var Invoices $invoice */
        $invoice = BaseApp::find('App:Invoices', $invoiceId);
        $paymentResult = $state->paymentResult;
        $orderRecord = null;
        switch ($paymentResult)
        {
            case CallbackState::PAYMENT_RECEIVED:
                $invoice->finalize();
                $invoice->invoice_state = 2;
                $invoice->request_key = $purchaseRequest->request_key;
                $invoice->save();
                $orderRecord = true;
                $state->logType = 'payment';
                $state->logMessage = 'Payment received, order processed.';
                break;

            case CallbackState::PAYMENT_REINSTATED:
                if ($hasOrderRecord)
                {
                    $invoice->invoice_state = 10;
                    $invoice->save();
                    $state->logType = 'payment';
                    $state->logMessage = 'Reversal cancelled, order reactivated.';
                }
                else
                {
                    $state->logType = 'info';
                    $state->logMessage = 'OK, no action.';
                }
                break;
        }
        if ($orderRecord && $purchaseRequest)
        {
            $extraData = $purchaseRequest->extra_data;
            $extraData['invoice_record'] = true;
            $purchaseRequest->extra_data = $extraData;
            $purchaseRequest->save();
        }
    }

    public function reversePurchase(CallbackState $state)
    {
        $purchaseRequest = $state->getPurchaseRequest();
        $invoiceId = $purchaseRequest->extra_data['invoice_id'];
        /** @var Invoices $invoice */
        $invoice = BaseApp::find('App:Invoices', $invoiceId);
        if ($invoice)
        {
            $invoice->invoice_state = 10;
            $invoice->save();
        }
        $state->logType = 'cancel';
        $state->logMessage = 'Payment refunded/reversed, order reversed';
    }

    public function getPurchasablesByProfileId($profileId)
    {
        return 1;
    }
}