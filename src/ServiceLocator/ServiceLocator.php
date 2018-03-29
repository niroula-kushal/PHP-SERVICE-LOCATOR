<?php

/**
* This file is the main file for the project. This class is responsible for 
* registering the services and retireving the factory classes as well
* as creating the instance of the services through the factory class
*
* @author Kushal Niroula <niroulakushal31@gmail.com>
* @version 1.0.0
* @package Rehmat\ServiceLocator
*/

namespace Rehmat\ServiceLocator;

use Rehmat\ServiceLocator\Interfaces\ServiceLocator as ServiceLocatorInterface;

use Rehmat\ServiceLocator\Exceptions\ServiceNotRegisteredException;

class ServiceLocator implements ServiceLocatorInterface
{

	/**
	* The singleton instance of ServiceLocator
	* @var ServiceLocator | null
	*/
	private static $instance = null;
	
	private function __construct() { }

	/**
	* Returns the signleton instance of ServiceLocator
	* @return self
	*/
	public static function getInstance()
	{
		if (self::$instance === null) self::$instance = new self();
		return self::$instance;
	}

	/**
	* The list of services and their respective factory
	* @var array
	*/
	private $services = [];


	/**
	* @param string     path to the service 							$serviceKey   
	* @param string     path to the service factory  					$serviceFactory
	* @param string     the mode underwhich the mapping is required 	$mode
	*/
	public function register($serviceKey, $serviceFactory, $mode)
	{
		$this->services[$mode][$serviceKey] = $serviceFactory;
		return $this;
	}

	/**
	* @param string 	The service whose factory is required					$serviceKey
	* @param string     The mode under which the mappring will be preferred 	$mode
	* @return string | null The path to the mapped factory of the service or null    
	*/

	public function get($serviceKey, $mode)
	{
		if (isset($this->services[$mode][$serviceKey])) return $this->services[$mode][$serviceKey];
		foreach ($this->services as $mode => $servicesList) {
			if (isset($servicesList[$serviceKey])) return $servicesList[$serviceKey];
		}
		return null;
	}

	/**
	* @param string 	The service whose factory is required
	* @param string     The mode which is preferred
	* @return bool      True if a match is found, false otherwise
	*/

	public function has($serviceKey, $mode) : bool
	{
		return $this->get($serviceKey, $mode) ? true : false;
	}

	/**
	* Creates and returns the instance of the service by executing the invoke method of the factory class.
	* @param string      The service whose factory is required
	* @param string      The mode which is preferred
	* @return 			 The instance of the service
	* @throws ServiceNotRegisteredException
	*/

	public function create($serviceKey, $mode)
	{
		if (!$this->has($serviceKey, $mode)) throw new ServiceNotRegisteredException($serviceKey, $mode);

		$serviceFactoryPath = $this->get($serviceKey, $mode);

		$serviceFactory = new $serviceFactoryPath();
		$service = $serviceFactory();
		return $service;
	}
}