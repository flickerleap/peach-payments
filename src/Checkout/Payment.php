<?php

namespace FlickerLeap\PeachPayments\Checkout;

use GuzzleHttp\Exception\RequestException;
use FlickerLeap\PeachPayments\Client;
use FlickerLeap\PeachPayments\ClientInterface;
use FlickerLeap\PeachPayments\ResponseJson;

/**
 * Class Debit
 * @package FlickerLeap\PeachPayments\Checkout
 */
class Payment implements ClientInterface
{
	/**
     * FlickerLeap\PeachPayments client object.
     *
     * @var Client
     */
    private $client;

    /**
     * FlickerLeap\PeachPayments notificationUrl.
     *
     * @var NotificationUrl
     */
    private $notificationUrl;

    /**
     * @var amount
     */
    private $amount;

    /**
     * @var currency
     */
    private $currency = 'ZAR';

    /**
     * @var paymentType
     */
    private $paymentType = 'DB';

    /**
     * @var createRegistration
     */
    private $createRegistration = false;

    /**
     * @var shopperTokens
     */
    private $shopperTokens;

    /**
     * @var transactionId
     */
    private $transactionId;

    /**
     * Debit constructor.
     * @param Client $client
     * @param float $amount
     */
    public function __construct(Client $client, $amount, $notificationUrl, $shopperTokens, $transactionId)
    {
        $this->client = $client;
        $this->amount = $amount;
        $this->shopperResultUrl = $shopperResultUrl;
        $this->notificationUrl = $notificationUrl;
        $this->shopperTokens = $shopperTokens;
        $this->transactionId = $transactionId;
    }

    /**
     * Process debit payment procedure.
     * @return \stdClass
     * @throws \Exception
     */
    public function process()
    {
    	$client = $this->client->getClient();

    	try {
            $response = $client->post($this->buildUrl(), [
                'form_params' => $this->getParams()
            ]);
            return new ResponseJson((string)$response->getBody(), true);
        } catch (RequestException $e) {
            return new ResponseJson((string)$e->getResponse()->getBody(), false);
        }
    }

    /**
     * @return string
     */
    public function buildUrl()
    {
        return $this->client->getApiUri() . '/checkouts';
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = [
            'authentication.userId' => $this->client->getConfig()->getUserId(),
            'authentication.password' => $this->client->getConfig()->getPassword(),
            'authentication.entityId' => $this->client->getConfig()->getEntityId(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'paymentType' => $this->getPaymentType(),
            'notificationUrl' => $this->notificationUrl,
            'merchantTransactionId' => $this->getTransactionId(),
            'token' => $this->getShopperTokens(), // array of stored shopper tokens
            'recurringType' => 'REGISTRATION_BASED', // Used to skip 3D secure
        ];

        // save card
        if ($this->isCreateRegistration()) {
            $params['createRegistration'] = true;
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }
    /**
     * @param string $paymentType
     * @return $this
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->currency);
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        // oppwa format
        return number_format($this->amount, 2, '.', '');
    }

    /*
    *
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return array
     */
    public function getShopperTokens()
    {
        return $this->shopperTokens;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return boolean
     */
    public function isCreateRegistration()
    {
        return $this->createRegistration;
    }

    /**
     * @param boolean $createRegistration
     * @return $this
     */
    public function setCreateRegistration($createRegistration)
    {
        $this->createRegistration = $createRegistration;
        return $this;
    }
}