<?php

namespace FlickerLeap\PeachPayments\Payments;

use GuzzleHttp\Exception\RequestException;
use FlickerLeap\PeachPayments\Client;
use FlickerLeap\PeachPayments\ClientInterface;
use FlickerLeap\PeachPayments\ResponseJson;

/**
 * Class Status
 * @package FlickerLeap\PeachPayments\Payments
 */
class Status implements ClientInterface
{
	const EXCEPTION_EMPTY_STATUS_TID = 400;

	/**
     * FlickerLeap\PeachPayments client object.
     *
     * @var Client
     */
    private $client;

    /**
     * @var null|string
     */
    private $checkoutId = '';

    /**
     * Status constructor.
     * @param Client $client
     * @param null $checkoutId
     */
    public function __construct(Client $client, $checkoutId = null)
    {
        $this->client = $client;

        if (!empty($checkoutId)) {
            $this->checkoutId = $checkoutId;
        }
    }

    /**
     * @return ResponseJson
     * @throws \Exception
     */
    public function process()
    {
        if (empty($this->getCheckoutId())) {
            throw new \Exception("Transaction Id can not be empty", self::EXCEPTION_EMPTY_STATUS_TID);
        }
        $client = $this->client->getClient();
        try {
            $response = $client->get($this->buildUrl());
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
        return $this->client->getApiUri() . '/checkouts/' . $this->getCheckoutId() . '/payment' . 
        '?authentication.userId=' . $this->client->getConfig()->getUserId() .
        '&authentication.password=' . $this->client->getConfig()->getPassword() .
        '&authentication.entityId=' . $this->client->getConfig()->getEntityId();
    }

    /**
     * @return string
     */
    public function getCheckoutId()
    {
        return $this->checkoutId;
    }

    /**
     * @param $checkoutId
     * @return $this
     */
    public function setCheckoutId($checkoutId)
    {
        $this->checkoutId = $checkoutId;
        return $this;
    }
}