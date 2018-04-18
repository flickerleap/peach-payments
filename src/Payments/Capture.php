<?php

namespace FlickerLeap\PeachPayments\Payments;

use GuzzleHttp\Exception\RequestException;
use FlickerLeap\PeachPayments\Client;
use FlickerLeap\PeachPayments\ClientInterface;
use FlickerLeap\PeachPayments\ResponseJson;

/**
 * Class Store
 * @package FlickerLeap\PeachPayments\Payments
 */
class Capture implements ClientInterface
{
	/**
     * FlickerLeap\PeachPayments client object.
     *
     * @var Client
     */
    private $client;

    /**
     * @var amount
     */
    private $amount;

    /**
     * Capture constructor.
     * @param Client $client
     * @param float $amount
     */
    public function __construct(Client $client, $amount = null)
    {
        $this->client = $client;

        if (!empty($amount)) {
            $this->amount = $amount;
        }
    }

    /**
     * Process capture payment procedure.
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
        return [
            'authentication.userId' => $this->client->getConfig()->getUserId(),
            'authentication.password' => $this->client->getConfig()->getPassword(),
            'authentication.entityId' => $this->client->getConfig()->getEntityId(),
            'amount' => $this->getAmount(),
            'currency' => 'ZAR',
            'paymentType' => 'DB',
            'shopperResultUrl' => 'my.app://custom/url',
            'notificationUrl' => 'http://www.example.com/notify'
        ];
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }
}