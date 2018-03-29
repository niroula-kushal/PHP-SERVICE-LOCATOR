<?php
namespace Rehmat\ServiceLocator\Interfaces;
interface ServiceLocator
{
	function register($serviceKey, $serviceFactory, $mode);
	function get($serviceKey, $mode);
	function has($serviceKey, $mode) : bool;
	function create($serviceKey, $mode);
}