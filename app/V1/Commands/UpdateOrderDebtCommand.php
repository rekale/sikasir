<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Orders\Order;
use Sikasir\V1\Orders\Void;
use Sikasir\V1\User\User;
use Sikasir\V1\Orders\Debt;

class UpdateOrderDebtCommand extends UpdateCommand 
{
	
	private $makeDebtJob = false;
	private $makeDebtSettledJob = false;
	
	/**
	 * 
	 * @return $this
	 */
	public function makeDebt()
	{
		$this->makeDebtJob = true;
		
		return $this;
	}
	
	/**
	 * 
	 * @return $this
	 */
	public function makeDebtSettled()
	{
		$this->makeDebtSettledJob = true;

		return $this;
	}
	
	public function execute() 
	{
		\DB::transaction(function () {
			
			if ($this->makeDebtJob) {
			
				$debt = new Debt([
					'total' => $this->data['total'],
					'due_date' => $this->data['due_date']
				]);
				
				$this->repo
				->find($this->id)
				->debt()
				->save($debt);	
			
			}
			
			if($this->makeDebtSettledJob) {
				
				$debt = $this->repo->find($this->id)->debt;
				
				$debt->paid_at = $this->data['paid_at'];
				
				$debt->save();
			}
			
		});
	}
}