<?php

namespace FlickerLeap\PeachPayments\Cards;

use GuzzleHttp\Exception\RequestException;
use FlickerLeap\PeachPayments\Client;
use FlickerLeap\PeachPayments\ClientInterface;
use FlickerLeap\PeachPayments\ResponseJson;

/**
 * Class Store
 * @package FlickerLeap\PeachPayments\Cards
 */
class Store implements ClientInterface
{
	/**
     * FlickerLeap\PeachPayments client object.
     *
     * @var Client
     */
    private $client;

    /**
     * Store constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Process store card procedure.
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
            'amount' => 0.00,
            'currency' => 'ZAR',
            'createRegistration' => true,
            'shopperResultUrl' => 'my.app://custom/url',
            'notificationUrl' => 'http://www.example.com/notify'
        ];
    }
}