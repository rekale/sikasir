<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\UpdateCommand;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Util\Obfuscater;

class UpdateUserCommand extends UpdateCommand
{

	public function execute()
	{
		\DB::transaction(function () {

			$user = $this->repo->find($this->id);

			$authorizer = new Authorizer($user);

			if ($this->data['title'] === 1) {
				$authorizer->managerDefault();
			}
			if ($this->data['title'] === 2) {
				$authorizer->cashierDefault();
			}
			if ($this->data['title'] === 3) {
				$authorizer->ownerDefault();
			}

			$this->data['password'] = bcrypt($this->data['password']);

			$user->update($this->data);

			$authorizer->syncAccess($this->data['privileges']);

			$outletIds = Obfuscater::decode($this->data['outlet_id']);

			$user->outlets()->sync($outletIds);

		});
	}
}
