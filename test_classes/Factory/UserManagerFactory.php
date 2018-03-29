<?php
namespace TestClasses\Factory;

use TestClasses\UserManager;

class UserManagerFactory
{
	public function __invoke()
	{
		return new UserManager();
	}
}