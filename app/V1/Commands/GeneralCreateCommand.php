<?php

namespace Sikasir\V1\Commands;

class GeneralCreateCommand extends CreateCommand
{

	public function execute()
	{
		$data = $this->factory->create($this->data);

		return $data->id;
	}
}
