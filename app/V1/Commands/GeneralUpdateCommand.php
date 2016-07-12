<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\UpdateCommand;

class GeneralUpdateCommand extends UpdateCommand
{
	public function execute()
	{
		$entity = $this->repo->find($this->id);

		$entity->update($this->data);

		return $entity->id;
	}
}
