<?php

namespace Sikasir\V1\Commands;

class GeneralCreateCommand extends CreateCommand
{
	
	public function execute()
	{
		$this->factory($this->data);
	}
}