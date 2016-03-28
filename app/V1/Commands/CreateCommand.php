<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Factories\Factory;

abstract  class CreateCommand
{
	protected $factory;
	protected $data;
	
	public function  __construct(Factory $factory)
	{
		$this->factory = $factory;
		$this->data = $data;
	}
	
	public function setData($data)
	{
		$this->data = $data;
	}

	public function execute();
	
}