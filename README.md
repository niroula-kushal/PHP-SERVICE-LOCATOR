# PHP-SERVICE-LOCATOR
A simple and light weight Dependency Injection library for PHP projects.

##Requires
composer autoloading

#How to use?

In your php code, make sure to require composer's autoload
```php
require 'vendor/autoload.php';
```
You have to import the Rehmat\ServiceLocator\ServiceLocator namespace
```
use Rehmat\ServiceLocator\ServiceLocator;
//instantiate ServiceLocator
$serviceLocator = ServiceLocator::getInstance();

//add configuration through which ServiceLocator can locate the factory to create your desired classes
// the ::class is required for retrieving the Fully Qualified Class Name (FQCN)
$serviceLocator->register(MyClassInterface::class, MyClassFactory::class, 'prod' );
```
The first parameter is the class that we want to register, the second parameter is the factory that we want to use when locating our class, the third parameter is used as a mode, while retrieving our class, if same class is registered twice but under different mode, the mode we specify takes precedence.

```
$myClassObj = $serviceLocator->create(MyClassInterface::class, 'prod');
```

Or, you can use our config reader and do it in a much quicker way.

```
//change this line to use ConfigReader too
use Rehmat\ServiceLocator\{ServiceLocator, ConfigReader};

$configs = [
	'prod'	=> [
		MyClassInterface::class => MyClassFactory::class
	]
];

(new ConfigReader())->fromArray($configs);

```
