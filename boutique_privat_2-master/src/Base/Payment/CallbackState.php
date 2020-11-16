<?php

namespace Base\Payment;

use Base\Entity\PurchaseRequest;
use App\Entity\User;
use Base\BaseApp;
use Base\Purchasable\AbstractPurchasable;
use Base\Purchasable\Purchasable;

/**
 * @property PurchaseRequest $purchaseRequest
 * @property AbstractPurchasable $purchasableHandler
 * @property User $purchaser;
 *
 * @property int $paymentResult
 *
 * @property string $requestKey
 *
 * @property string $transactionId
 * @property string $subscriberId
 * @property string $paymentCountry
 *
 * @property string $logType
 * @property string $logMessage
 * @property array $logDetails
 * @property int $httpCode
 */
class CallbackState
{
    protected $purchaseRequest;
    protected $purchasableHandler;
    protected $paymentProfile;
    protected $purchaser;
    protected $paymentResult;

    const PAYMENT_RECEIVED = 1;
    const PAYMENT_REVERSED = 2;
    const PAYMENT_REINSTATED = 3;

    /**
     * @return PurchaseRequest
     */
	public function getPurchaseRequest()
	{
		return $this->purchaseRequest;
	}

    /**
     * @return AbstractPurchasable|bool|mixed|null
     */
	public function getPurchasableHandler()
	{
		if ($this->purchasableHandler)
		{
			return $this->purchasableHandler;
		}

		$purchaseRequest = $this->getPurchaseRequest();
		if (!$purchaseRequest)
		{
			return false;
		}

		/** @var Purchasable $purchasable */
		$purchasable = BaseApp::getPurchasable($purchaseRequest->purchasable_type_id);
		if (!$purchasable || !$purchasable->getHandler())
		{
			return false;
		}

		$this->purchasableHandler = $purchasable->getHandler();
		return $this->purchasableHandler;
	}

    /**
     * @return Payment|bool
     */
    public function getPaymentProfile()
    {
        if ($this->paymentProfile)
        {
            return $this->paymentProfile;
        }

        $purchaseRequest = $this->getPurchaseRequest();
        if (!$purchaseRequest)
        {
            return false;
        }
        $paymentProfile = BaseApp::getPayment($purchaseRequest->provider_id);
        if (!$paymentProfile)
        {
            return false;
        }

        $this->paymentProfile = $paymentProfile;
        return $this->paymentProfile;
    }

    /**
     * @return User|bool|mixed|null
     * @throws \Exception
     */
	public function getPurchaser()
	{
		if ($this->purchaser)
		{
			return $this->purchaser;
		}

		$purchaseRequest = $this->purchaseRequest;
		if (!$purchaseRequest)
		{
			return false;
		}

		$user = BaseApp::find('App:User', $purchaseRequest->user_id);
		if (!$user)
		{
			return false;
		}

		$this->purchaser = $user;
		return $this->purchaser;
	}

    /**
     * @param $name
     * @return |null
     */
	function __get($name)
	{
		return isset($this->{$name}) ? $this->{$name} : null;
	}

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
	function __set($name, $value)
	{
		switch ($name)
		{
			case 'purchaseRequest':
				$this->purchaseRequest = $value;
				if ($value)
				{
					$this->requestKey = $value->request_key;
				}
				break;

			case 'requestKey':
				$this->purchaseRequest = BaseApp::finder('Base:PurchaseRequest')
                    ->where('request_key', $value)
                    ->fetchOne();
				$extraData = $this->purchaseRequest->extra_data;
                $extraData['dddddd'] = $value;
                $this->purchaseRequest->extra_data = $extraData;
                $this->purchaseRequest->save();
				$this->requestKey = $value;
				break;

			default:
				$this->{$name} = $value;
				break;
		}
	}
}