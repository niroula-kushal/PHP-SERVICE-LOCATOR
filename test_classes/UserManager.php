<?php
namespace TestClasses;

use TestClasses\Interfaces\UserManager as UserManagerInterface;

/**
* Class for managing users
*/
class UserManager implements UserManagerInterface
{
	public function getHola()
	{
		return "Hola";
	}
}