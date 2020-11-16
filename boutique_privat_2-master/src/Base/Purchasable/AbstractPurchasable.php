<?php

namespace Base\Purchasable;

use App\Entity\User;
use Base\Payment\CallbackState;
use Base\Request;

abstract class AbstractPurchasable
{
	protected $purchasableTypeId;

    /**
     * @return mixed
     */
	abstract public function getTitle();

    /**
     * @param Request $request
     * @param User $purchaser
     * @param null $error
     * @return mixed
     */
	abstract public function getPurchaseFromRequest(Request $request, User $purchaser, &$error = null);

    /**
     * @param array $extraData
     * @return mixed
     */
	abstract public function getPurchasableFromExtraData(array $extraData);

    /**
     * @param array $extraData
     * @param $paymentProfile
     * @param User $purchaser
     * @param null $error
     * @return mixed
     */
	abstract public function getPurchaseFromExtraData(array $extraData, $paymentProfile, User $purchaser, &$error = null);

    /**
     * @param $paymentProfile
     * @param $purchasable
     * @param User $purchaser
     * @return mixed
     */
	abstract public function getPurchaseObject( $paymentProfile, $purchasable, User $purchaser);

	/**
	 * @param CallbackState $state
	 *
	 * @return mixed
	 */
	abstract public function completePurchase(CallbackState $state);

	/**
	 * @param CallbackState $state
	 *
	 * @return mixed
	 */
	abstract public function reversePurchase(CallbackState $state);

    /**
     * @param CallbackState $state
     * @param null $error
     * @return bool
     * @throws \Exception
     */
	public function validatePurchaser(CallbackState $state, &$error = null)
	{
		if (!$state->getPurchaser())
		{
			if ($state->getPurchaseRequest()->user_id)
			{
				$error = 'Could not find user with user_id ' . $state->getPurchaseRequest()->user_id . '.';
			}
			else
			{
				$error = 'Purchasable type ' . $this->purchasableTypeId . ' does not support payments from guests.';
			}

			return false;
		}
		return true;
	}

    /**
     * @param $profileId
     * @return mixed
     */
	abstract public function getPurchasablesByProfileId($profileId);

    /**
     * AbstractPurchasable constructor.
     * @param $purchasableTypeId
     */
	public function __construct($purchasableTypeId)
	{
		$this->purchasableTypeId = $purchasableTypeId;
	}

    /**
     * @param CallbackState $state
     * @throws \Exception
     */
    public function sendPaymentReceipt(CallbackState $state)
    {
        $purchaser = $state->getPurchaser();
        if (!$purchaser || !$purchaser->email)
        {
            return;
        }

        switch ($state->paymentResult)
        {
            case CallbackState::PAYMENT_RECEIVED:
            {
                $purchaseRequest = $state->getPurchaseRequest();
            }
        }
    }

    /**
     * @param CallbackState $state
     */
	public function postCompleteTransaction(CallbackState $state)
	{
	}
}