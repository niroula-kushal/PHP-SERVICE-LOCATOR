<?php
namespace Rehmat\ServiceLocator\Tests;

use PHPUnit\Framework\TestCase;

use Rehmat\ServiceLocator\ServiceLocator;

use Rehmat\ServiceLocator\Exceptions\ServiceNotRegisteredException;

class ServiceLocatorTest extends TestCase
{
	public function setUp()
	{
		$this->serviceLocator = ServiceLocator::getInstance();
	}

	public function testRegisterRegistersService()
	{
		$key   = "serviceKey";
		$value = "ServiceFactory";
		$mode  = "dev";
		$this->serviceLocator->register($key, $value, $mode);
		$this->assertSame($this->serviceLocator->get($key, $mode), $value);
	}

	public function testIfNoServiceMatch_get_ReturnsNull()
	{
		$this->assertNull($this->serviceLocator->get("Hola","Bhola"));
	}

	public function test_getReturnsValue_evenWhenTheKeyIsPresentInAnotherMode()
	{
		$key = "serviceKey";
		$value = "ServiceFactory";
		$mode  = "prod";

		$differentMode = "DEV";

		$this->serviceLocator->register($key, $value, $mode);

		$this->assertSame($this->serviceLocator->get($key, $differentMode), $value);
	}

	public function test_whenNoServiceMatch_has_returnsFalse()
	{
		$this->assertFalse($this->serviceLocator->has("hola", "Bhola"));
	}

	public function test_whenAServiceMatches_has_returnsTrue()
	{
		$key = "serviceKey";
		$value = "ServiceFactory";
		$mode  = "dev";
		$this->serviceLocator->register($key, $value,$mode);
		$this->assertTrue($this->serviceLocator->has($key, $value));
	}

	public function test_whenAServiceMatches_evenWithDifferentMode_has_returnsTrue()
	{
		$key = "serviceKey";
		$value = "ServiceFactory";
		$mode  = "prod";

		$differentMode = "DEV";

		$this->serviceLocator->register($key, $value, $mode);

		$this->assertTrue($this->serviceLocator->has($key, $differentMode));
	}

	public function test_whenNoServiceMatch_create_throwsException()
	{
		$this->expectException(ServiceNotRegisteredException::class);
		$this->serviceLocator->create("hola", "Bhola");
	}

	public function test_ServiceLocatorCannotBeInstantiatedWithNewKeyword()
	{
		$this->expectException(\Error::class);
		new ServiceLocator();
	}

	public function test_everyInstanceReturnedBy_getInstance_isTheSame()
	{
		$serviceLocatorFirst = ServiceLocator::getInstance();
		$serviceLocatorSecond = ServiceLocator::getInstance();
		$this->assertSame($serviceLocatorFirst, $serviceLocatorSecond);
	}

	public function test_getInstance_returnsInstanceOfServiceLocator()
	{
		$serviceLocator = ServiceLocator::getInstance();
		$this->assertTrue($serviceLocator instanceof  ServiceLocator);
	}

	public function test_create_CallsTheInvokeMethodOfValue_whichIsAFactory()
	{
		$this->serviceLocator->register(\TestClasses\Interfaces\UserManager::class, \TestClasses\Factory\UserManagerFactory::class, "dev");
		$this->assertTrue($this->serviceLocator->create(\TestClasses\Interfaces\UserManager::class, "dev") instanceof \TestClasses\UserManager );
	}

}