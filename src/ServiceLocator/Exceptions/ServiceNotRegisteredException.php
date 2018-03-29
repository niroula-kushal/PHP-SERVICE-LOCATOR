<?php
namespace Rehmat\ServiceLocator\Exceptions;

class ServiceNotRegisteredException extends \Exception
{
	public function __construct($serviceKey, $mode)
	{
		$this->serviceKey = $serviceKey;
		$this->mode       = $mode;
	}
}