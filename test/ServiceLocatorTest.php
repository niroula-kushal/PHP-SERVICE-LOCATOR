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
		$this->assertSame($this->serviceLocator->getValue($key, $mode), $value);
	}

	public function testIfNoServiceMatch_getValue_ReturnsNull()
	{
		$this->assertNull($this->serviceLocator->getValue("Hola","Bhola"));
	}

	public function test_getValue__ReturnsValue_evenWhenTheKeyIsPresentInAnotherMode()
	{
		$key = "serviceKey";
		$value = "ServiceFactory";
		$mode  = "prod";

		$differentMode = "DEV";

		$this->serviceLocator->register($key, $value, $mode);

		$this->assertSame($this->serviceLocator->getValue($key, $differentMode), $value);
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

	public function test_whenNoServiceMatch_get_throwsException()
	{
		$this->expectException(ServiceNotRegisteredException::class);
		$this->serviceLocator->get("hola", "Bhola");
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

	public function test__get__returns_theReturnValueOfTheCallable_when_theValueIsCallable()
	{
		$returnVal = "You should have gone for the head";
		$this->serviceLocator->register('hola', function() use ($returnVal) { return $returnVal; } );
		$this->assertSame($returnVal, $this->serviceLocator->get('hola'));
	}

	public function test__get__returns_theValue_when_theValueIsNiether_Callable_nor_class()
	{
		$returnObj = new \StdClass();
		$this->serviceLocator->register('hola', $returnObj);
		$this->assertSame($returnObj, $this->serviceLocator->get('hola'));
	}

	public function test_get_CallsTheInvokeMethodOfValue_when_theValueIsClass()
	{
		$this->serviceLocator->register(\TestClasses\Interfaces\UserManager::class, \TestClasses\Factory\UserManagerFactory::class, "dev");
		$this->assertTrue($this->serviceLocator->get(\TestClasses\Interfaces\UserManager::class, "dev") instanceof \TestClasses\UserManager );
	}

}