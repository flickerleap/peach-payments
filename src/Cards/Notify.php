<?php

namespace FlickerLeap\PeachPayments\Cards;

use GuzzleHttp\Exception\RequestException;
use FlickerLeap\PeachPayments\Client;
use FlickerLeap\PeachPayments\ClientInterface;
use FlickerLeap\PeachPayments\ResponseJson;

class Notify implements ClientInterface
{
	// api location and version
    const API_URI_TEST = 'https://test.oppwa.com/';
    const API_URI_LIVE = 'https://oppwa.com/';

    // exceptions
    const EXCEPTION_BAD_CONFIG = 400;

	/**
     * FlickerLeap\PeachPayments client object.
     *
     * @var Client
     */
    private $client;

    /**
     * Request request.
     *
     * @var Request
     */
    private $request;

    /**
     * Store constructor.
     * @param Client $client
     */
    public function __construct(Client $client, $request)
    {
        $this->client = $client;
        $this->request = $request;
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
        return $this->client->getNotifyUri() . $this->request->resourcePath .  
        '?authentication.userId=' . $this->client->getConfig()->getUserId() .
        '&authentication.password=' . $this->client->getConfig()->getPassword() .
        '&authentication.entityId=' . $this->client->getConfig()->getEntityId();
    }
}