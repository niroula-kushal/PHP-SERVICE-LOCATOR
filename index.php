<?php
require_once 'vendor/autoload.php';

use Rehmat\ServiceLocator\{ServiceLocator,ConfigReader};

$serviceLocator = ServiceLocator::getInstance();

$configs = [
	'dev'	=> [
		TestClasses\Interfaces\UserManager::class => \TestClasses\Factory\UserManagerFactory::class
	]
];

(new ConfigReader())->fromArray($configs);

$userManager = $serviceLocator->create(\TestClasses\Interfaces\UserManager::class, "dev");

echo $userManager->getHola();