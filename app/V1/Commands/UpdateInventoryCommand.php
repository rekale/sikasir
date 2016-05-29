<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\UpdateCommand;

class UpdateInventoryCommand extends UpdateCommand
{
	public function execute()
	{
		$entity = $this->repo->find($this->id);

		$entity->update([
			'note' => $this->data['note'],
		]);
	}
}
