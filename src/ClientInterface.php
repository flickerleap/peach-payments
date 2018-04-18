<?php

namespace FlickerLeap\Peachpayments;

/**
 * Interface ClientInterface
 * @package FlickerLeap\Peachpayments;
 */
interface ClientInterface
{
    /**
     * Make request
     *
     * @return array
     */
    public function process();

    /**
     * Build Url to call in api
     *
     * @return string
     */
    public function buildUrl();
}