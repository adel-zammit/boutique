<?php

namespace Base\Payment;



use Base\Entity\PurchaseRequest;
use Base\BaseApp;
use Base\Mvc\Controller;
use Base\Purchasable\Purchase;
use Base\Util\Arr;
use http\Env\Request;

class PayPal extends AbstractProvider
{
    /**
     * @return mixed|string
     */
	public function getTitle()
	{
		return 'PayPal';
	}

    /**
     * @return string
     */
	public function getApiEndpoint()
	{
		if (BaseApp::getConfigOptions()->enableLivePayments)
		{
			return 'https://www.paypal.com/cgi-bin/webscr';
		}
		else
		{
			return 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}
	}

    /**
     * @param PurchaseRequest $purchaseRequest
     * @param Purchase $purchase
     * @return array
     */
	protected function getPaymentParams(PurchaseRequest $purchaseRequest, Purchase $purchase)
	{
		$purchaser = $purchase->purchaser;

		$params = [
			'business' => BaseApp::getConfigOptions()->AccountPayPal,
			'currency_code' => $purchase->currency,
			'item_name' => $purchase->title,
			'quantity' => 1,
			'no_note' => 1,
			'no_shipping' => 2,

			'custom' => $purchaseRequest->request_key,

			'charset' => 'utf8',
			'email' => $purchaser->email,

			'return' => $purchase->returnUrl,
			'cancel_return' => $purchase->cancelUrl,
			'notify_url' => $this->getCallbackUrl()
		];
        $params['cmd'] = '_xclick';
        $params['amount'] = $purchase->cost;

		return $params;
	}

    /**
     * @param Controller $controller
     * @param PurchaseRequest $purchaseRequest
     * @param Purchase $purchase
     * @return \Base\Reply\Redirect|mixed
     */
	public function initiatePayment(Controller $controller, PurchaseRequest $purchaseRequest, \Base\Purchasable\Purchase $purchase)
	{
		$params = $this->getPaymentParams($purchaseRequest, $purchase);
		$endpointUrl = $this->getApiEndpoint();
		$endpointUrl .= '?' . http_build_query($params);
		return $controller->redirect($endpointUrl, '');
	}

    /**
     * @param Request $request
     * @return CallbackState
     */
	public function setupCallback(\Base\Request $request)
	{
		$state = new CallbackState();

		$state->business = $request->filter('business', 'str');
		$state->receiverEmail = $request->filter('receiver_email', 'str');
		$state->transactionType = $request->filter('txn_type', 'str');
		$state->parentTransactionId = $request->filter('parent_txn_id', 'str');
		$state->transactionId = $request->filter('txn_id', 'str');
		$state->subscriberId = $request->filter('subscr_id', 'str');
		$state->paymentCountry = $request->filter('residence_country', 'str');
		$state->costAmount = $request->filter('mc_gross', 'unum');
		$state->taxAmount = $request->filter('tax', 'unum');
		$state->costCurrency = $request->filter('mc_currency', 'str');
		$state->paymentStatus = $request->filter('payment_status', 'str');

		$state->requestKey = $request->filter('custom', 'str');
		$state->testMode = $request->filter('test_ipn', 'bool');

		if (BaseApp::getConfigOptions()->enableLivePayments)
		{
			$state->testMode = false;
		}

		$state->ip = 0;
		$state->_POST = $_POST;

		return $state;
	}

    /**
     * @param CallbackState $state
     * @return bool
     */
	public function validateCallback(CallbackState $state)
	{
		try
		{
			$params = ['form_params' => $state->_POST + ['cmd' => '_notify-validate']];
			if($state->testMode)
            {
                $url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
            }
			else
            {
                $url = 'https://ipnpb.paypal.com/cgi-bin/webscr';
            }
			$client = BaseApp::crateClient();

			$response = $client->post($url, $params);
			if (!$response || $response->getBody()->getContents() != 'VERIFIED' || $response->getStatusCode() != 200)
			{
				return false;
			}
		}
		catch (\GuzzleHttp\Exception\RequestException $e)
		{
			$state->logType = 'error';
			$state->logMessage = 'Connection to PayPal failed: ' . $e->getMessage();
			return false;
		}

		return true;
	}

    /**
     * @param CallbackState $state
     * @return bool
     * @throws \Exception
     */
	public function validateTransaction(CallbackState $state)
	{
		if (!$state->requestKey)
		{
			$state->logType = 'info';
			$state->logMessage = 'No purchase request key. Unrelated payment, no action to take.';
			return false;
		}

		if ($state->legacy)
		{
			if (!preg_match(
				'/^(?P<user_id>\d+),(?P<user_upgrade_id>\d+),token,.*$/',
				$state->requestKey,
				$itemParts)
				&& count($itemParts) !== 3 // full match + 2 groups
			)
			{
				$state->logType = 'info';
				$state->logMessage = 'Invalid custom field. Unrelated payment, no action to take.';
				return false;
			}

			$user = BaseApp::find('XF:User', $itemParts['user_id']);
			if (!$user)
			{
				$state->logType = 'error';
				$state->logMessage = 'Could not find user with user_id ' . $itemParts['user_id'] . '.';
				return false;
			}
			$state->purchaser = $user;
		}
		else
		{
			if (!$state->getPurchaseRequest())
			{
				$state->logType = 'info';
				$state->logMessage = 'Invalid request key. Unrelated payment, no action to take.';
				return false;
			}
		}

		if (!$state->transactionId && !$state->subscriberId)
		{
			$state->logType = 'info';
			$state->logMessage = 'No transaction or subscriber ID. No action to take.';
			return false;
		}
		/** @var Payment $paymentRepo */
		$paymentRepo = $state->getPaymentProfile();;
		$matchingLogsFinder = $paymentRepo->findLogsByTransactionIdForProvider($state->transactionId, $this->providerId);
		if ($matchingLogsFinder->total())
		{
			$logs = $matchingLogsFinder->fetch();
			foreach ($logs AS $log)
			{
				if ($log->log_type == 'cancel' && $state->paymentStatus == 'Canceled_Reversal')
				{
					return true;
				}
			}

			$state->logType = 'info';
			$state->logMessage = 'Transaction already processed. Skipping.';
			return false;
		}

		return true;
	}

    /**
     * @param CallbackState $state
     * @return bool
     */
	public function validatePurchaseRequest(CallbackState $state)
	{
		return true;
	}

    /**
     * @param CallbackState $state
     * @return bool
     */
	public function validatePurchasableHandler(CallbackState $state)
	{
		return parent::validatePurchasableHandler($state);
	}

    /**
     * @param CallbackState $state
     * @return bool
     */
	public function validatePaymentProfile(CallbackState $state)
	{
		return parent::validatePaymentProfile($state);
	}

    /**
     * @param CallbackState $state
     * @return bool
     */
	public function validatePurchaser(CallbackState $state)
	{
		if ($state->legacy)
		{
			return true;
		}
		else
		{
			return parent::validatePurchaser($state);
		}
	}

    /**
     * @param CallbackState $state
     * @return bool
     */
	public function validatePurchasableData(CallbackState $state)
	{
		$business = strtolower($state->business);
		$receiverEmail = strtolower($state->receiverEmail);
        $account = BaseApp::getConfigOptions()->AccountPayPal;
		if (!$account && ($business != $account || $receiverEmail != $account))
		{
			$state->logType = 'error';
			$state->logMessage = 'Invalid business or receiver_email.';
			return false;
		}

		return true;
	}

    /**
     * @param CallbackState $state
     * @return bool
     */
	public function validateCost(CallbackState $state)
	{
        $purchaseRequest = $state->getPurchaseRequest();
        $cost = $purchaseRequest->cost_amount;
        $currency = $purchaseRequest->cost_currency;
        switch ($state->transactionType)
        {
            case 'web_accept':
            case 'subscr_payment':
                $costValidated = (
                    round(($state->costAmount - $state->taxAmount), 2) == round($cost, 2)
                    && $state->costCurrency == $currency
                );

                if (!$costValidated)
                {
                    $state->logType = 'error';
                    $state->logMessage = 'Invalid cost amount';
                    return false;
                }
        }
		return true;
	}

    /**
     * @param CallbackState $state
     * @return mixed|void
     */
	public function getPaymentResult(CallbackState $state)
	{
		switch ($state->transactionType)
		{
			case 'web_accept':
			case 'subscr_payment':
				if ($state->paymentStatus == 'Completed')
				{
					$state->paymentResult = CallbackState::PAYMENT_RECEIVED;
				}
				break;
		}

		if ($state->paymentStatus == 'Refunded' || $state->paymentStatus == 'Reversed')
		{
			$state->paymentResult = CallbackState::PAYMENT_REVERSED;
		}
		else if ($state->paymentStatus == 'Canceled_Reversal')
		{
			$state->paymentResult = CallbackState::PAYMENT_REINSTATED;
		}
	}

    /**
     * @param CallbackState $state
     * @return mixed|void
     */
	public function prepareLogData(CallbackState $state)
	{
		$state->logDetails = $state->_POST;
	}

    /**
     * @return array
     */
	protected function getSupportedRecurrenceRanges()
	{
		return [
			'day' => [1, 90],
			'week' => [1, 52],
			'month' => [1, 24],
			'year' => [1, 5]
		];
	}
}