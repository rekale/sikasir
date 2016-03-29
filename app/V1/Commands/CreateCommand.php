<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Factories\Factory;

abstract class CreateCommand
{
	protected $factory;
	protected $data;
	
	public function  __construct(Factory $factory)
	{
		$this->factory = $factory;
	}
	
	public function setData(array $data)
	{
		$this->data = $data;
	}
	
	abstract public function execute();
	
}