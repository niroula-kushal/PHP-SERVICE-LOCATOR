<?php
namespace Rehmat\ServiceLocator;

class Factory
{
    protected $serviceLocator;

    public function __construct()
    {
      $this->serviceLocator = ServiceLocator::getInstance();
    }
     
    public function get($key)
    {
      return $this->serviceLocator->get($key);
    }
    
}
