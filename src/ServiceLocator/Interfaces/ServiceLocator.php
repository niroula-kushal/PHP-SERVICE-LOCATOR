<?php
namespace Rehmat\ServiceLocator\Interfaces;
interface ServiceLocator
{
	function register($serviceKey, $serviceFactory, $mode);
	function getValue($serviceKey, $mode);
	function has($serviceKey, $mode) : bool;
	function get($serviceKey, $mode);
}