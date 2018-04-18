<?php

namespace FlickerLeap\PeachPayments;

/**
* 
*/
class Test
{
	
	protected $message;

	public function __construct($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}
}