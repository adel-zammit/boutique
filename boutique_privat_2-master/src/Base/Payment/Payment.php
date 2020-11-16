<?php


namespace Base\Payment;


use Base\Entity\PaymentProviderLog;
use Base\BaseApp;

class Payment
{
    protected $classString;
    protected $paymentString;

    /**
     * Payment constructor.
     * @param $classSting
     * @param $paymentString
     */
    public function __construct( $classSting, $paymentString)
    {
        $this->classString = $classSting;
        $this->paymentString = $paymentString;
    }

    /**
     * @return mixed
     */
    public function getPaymentString()
    {
        return $this->paymentString;
    }

    /**
     * @return mixed
     */
    public function getClassString()
    {
        return $this->classString;
    }

    /**
     * @return mixed|null
     */
    public function getPaymentHandler()
    {
        $class = BaseApp::stringToClass($this->classString, '%s\Payment\%s');
        if (!class_exists($class))
        {
            return null;
        }

        return new $class($this->paymentString);
    }

    /**
     * @param $requestKey
     * @param $providerId
     * @param $txnId
     * @param $logType
     * @param $logMessage
     * @param array $logDetails
     * @return \Base\Mvc\Entity\Entity|bool
     * @throws \Exception
     */
    public function logCallback($requestKey, $providerId, $txnId, $logType, $logMessage, array $logDetails)
    {
        /** @var PaymentProviderLog $providerLog */
        $providerLog = BaseApp::create('Base:PaymentProviderLog');

        if (strlen($requestKey) > 32)
        {
            $requestKey = substr($requestKey, 0, 29) . '...';
        }

        $providerLog->purchase_request_key = $requestKey;
        $providerLog->provider_id = $providerId;
        $providerLog->transaction_id = $txnId;
        $providerLog->log_type = $logType;
        $providerLog->log_message = $logMessage;
        $providerLog->log_details = $logDetails;
        $providerLog->log_date = time();

        return $providerLog->save();
    }

    /**
     * @param $transactionId
     * @param array $logType
     * @return \Base\Mvc\Entity\Finder
     * @throws \Exception
     */
    public function findLogsByTransactionId($transactionId, $logType = ['payment', 'cancel'])
    {
        return BaseApp::finder('Base:PaymentProviderLog')
            ->where('transaction_id', $transactionId)
            ->where('log_type', $logType)
            ->order('log_date');
    }

    /**
     * @param $transactionId
     * @param $providerId
     * @param array $logType
     * @return \Base\Mvc\Entity\Finder
     * @throws \Exception
     */
    public function findLogsByTransactionIdForProvider($transactionId, $providerId, $logType = ['payment', 'cancel'])
    {
        return $this->findLogsByTransactionId($transactionId, $logType)
            ->where('provider_id', $providerId);
    }
}