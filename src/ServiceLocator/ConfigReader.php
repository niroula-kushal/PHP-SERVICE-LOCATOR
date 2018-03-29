<?php
namespace Rehmat\ServiceLocator;

use Rehmat\ServiceLocator\ServiceLocator;

class ConfigReader
{
	private $serviceLocator = null;

	public function __construct()
	{
		$this->serviceLocator = ServiceLocator::getInstance();
	}

	public function fromJson($json)
	{
		$configs = json_decode($json, true);
		$this->fromArray($configs);
	}

	public function fromArray($configs)
	{
		foreach ($configs as $mode => $mapping) {
			foreach ($mapping as $serviceKey => $serviceFactory) {
				$this->serviceLocator->register($serviceKey, $serviceFactory, $mode);
			}
		}
	}

}