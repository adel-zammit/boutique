<?php
namespace Base\Payment;

use Base\Entity\PurchaseRequest;
use Base\Payment\CallbackState;
use Base\BaseApp;
use Base\Purchasable\Purchasable;
use Base\Purchasable\Purchase;
use Base\Mvc\Controller;

abstract class AbstractProvider
{
    const ERR_NO_RECURRING = 1;
    const ERR_INVALID_RECURRENCE = 2;
    const VALID_RECURRING = 3;

    /**
     * @var int
     */
    protected $providerId;

    /**
     * @return mixed
     */
    abstract public function getTitle();

    /**
     * @param PurchaseRequest $purchaseRequest
     * @param Purchase $purchase
     * @return array
     */
    protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
    {
        return [];
    }

    /**
     * @param Controller $controller
     * @param PurchaseRequest $purchaseRequest
     * @param Purchase $purchase
     * @return mixed
     */
    abstract public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, Purchase $purchase);

    /**
     * @param \Base\Request $request
     * @return mixed
     */
    abstract public function setupCallback(\Base\Request $request);

    /**
     * @param \Base\Payment\CallbackState $state
     * @return mixed
     */
    abstract public function getPaymentResult(CallbackState $state);

    /**
     * @param \Base\Payment\CallbackState $state
     * @return mixed
     */
    abstract public function prepareLogData(CallbackState $state);

    /**
     * AbstractProvider constructor.
     * @param $providerId
     */
    public function __construct($providerId)
    {
        $this->providerId = $providerId;
    }

    /**
     * @param PurchaseRequest $purchaseRequest
     * @return string
     */
    public function renderCancellationTemplate(PurchaseRequest $purchaseRequest)
    {
        return '';
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validateCallback(CallbackState $state)
    {
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validateTransaction(CallbackState $state)
    {
        /** @var Payment $payment */
        $payment = $state->getPaymentProfile();
        if ($payment->findLogsByTransactionIdForProvider($state->transactionId, $this->providerId)->total())
        {
            $state->logType = 'info';
            $state->logMessage = 'Transaction already processed. Skipping.';
            return false;
        }
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validatePurchaseRequest(CallbackState $state)
    {
        if (!$state->getPurchaseRequest())
        {
            $state->logType = 'error';
            $state->logMessage = 'Invalid purchase request.';
            return false;
        }
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validatePurchasableHandler(CallbackState $state)
    {
        if (!$state->getPurchasableHandler())
        {
            $state->logType = 'error';
            $state->logMessage = 'Could not find handler for purchasable type \'' . $state->getPurchaseRequest()->purchasable_type_id  . '\'.';
            return false;
        }
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validatePaymentProfile(CallbackState $state)
    {
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validatePurchaser(CallbackState $state)
    {
        $handler = $state->getPurchasableHandler();

        if (!$handler->validatePurchaser($state, $error))
        {
            $state->logType = 'error';
            $state->logMessage = $error;
            return false;
        }
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validatePurchasableData(CallbackState $state)
    {
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @return bool
     */
    public function validateCost(CallbackState $state)
    {
        return true;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     */
    public function setProviderMetadata(CallbackState $state)
    {
        return;
    }

    /**
     * @param \Base\Payment\CallbackState $state
     */
    public function completeTransaction(CallbackState $state)
    {
        $purchasableHandler = $state->getPurchasableHandler();

        switch ($state->paymentResult)
        {
            case CallbackState::PAYMENT_RECEIVED:
                $purchasableHandler->completePurchase($state);
                $purchasableHandler->sendPaymentReceipt($state);
                break;

            case CallbackState::PAYMENT_REINSTATED:
                $purchasableHandler->completePurchase($state);
                break;

            case CallbackState::PAYMENT_REVERSED:
                $purchasableHandler->reversePurchase($state);
                break;

            default:
                $state->logType = 'info';
                $state->logMessage = 'OK, no action';
                break;
        }

        $purchasableHandler->postCompleteTransaction($state);
    }

    /**
     * @param \Base\Payment\CallbackState $state
     * @throws \Exception
     */
    public function log(CallbackState $state)
    {
        $this->prepareLogData($state);
        /** @var Payment $payment */
        $payment = $state->getPaymentProfile();
        $payment->logCallback(
            $state->requestKey,
            $this->providerId,
            $state->transactionId,
            $state->logType,
            $state->logMessage,
            $state->logDetails
        );
    }

    /**
     * @param $paymentProfile
     * @param $unit
     * @param $amount
     * @param int $result
     * @return bool
     */
    public function supportsRecurring($paymentProfile, $unit, $amount, &$result = self::ERR_NO_RECURRING)
    {
        $supported = false;

        $ranges = $this->getSupportedRecurrenceRanges();
        if (isset($ranges[$unit]))
        {
            list($minRange, $maxRange) = $ranges[$unit];
            if ($amount >= $minRange && $amount <= $maxRange)
            {
                $supported = true;
            }
        }

        if ($supported)
        {
            $result = self::VALID_RECURRING;
        }
        else
        {
            $result = self::ERR_INVALID_RECURRENCE;
        }

        return $supported;
    }

    /**
     * @return array
     */
    protected function getSupportedRecurrenceRanges()
    {
        return [
            'day' => [1, 365],
            'week' => [1, 52],
            'month' => [1, 12],
            'year' => [1, 1]
        ];
    }

    /**
     * @param $paymentProfile
     * @param $currencyCode
     * @return bool
     */
    public function verifyCurrency($paymentProfile, $currencyCode)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getCallbackUrl()
    {
        return BaseApp::getConfigOptions()->baseUrl . '/payment_callback.php?_baseProvider=' . $this->providerId;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return '';
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return $this->providerId;
    }
}