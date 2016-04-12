<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Orders\Order;
use Sikasir\V1\Orders\Void;
use Sikasir\V1\User\User;

class UpdateOrderToVoidCommand extends UpdateCommand 
{
	
	private $operatorId;
	
	/**
	 * 
	 * @param integer $id
	 * 
	 * @return $this
	 */
	public function setOperator($id)
	{
		$this->operatorId = $id;
		
		return $this;
	}
	
	public function execute() 
	{
		\DB::transaction(function () {
			
			$this->data['user_id'] = $this->operatorId;
			
			$void = new Void($this->data);
			
			$this->repo
				->find($this->id)
				->void()
				->save($void);
			
		});
	}
}