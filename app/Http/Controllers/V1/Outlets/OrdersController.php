<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\OrderTransformer;
use Sikasir\Http\Requests\OrderRequest;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Reports\OrderReport;
use Illuminate\Http\Request;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Commands\CreateOrderCommand;
use Sikasir\V1\Orders\Void;
use Sikasir\V1\Commands\UpdateOrderToVoidCommand;
use Sikasir\V1\Commands\UpdateOrderDebtCommand;
use Sikasir\Http\Requests\DebtRequest;

class OrdersController extends ApiController
{
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-order';
		$this->showAccess = 'read-order';
		$this->storeAccess = 'edit-order';
		$this->reportAccess = 'report-order';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new Order, $this->auth->getCompanyId(), 'outlets', $throughId
		);
	}
	
	public function getRepository($throughId = null)
	{
		return new EloquentRepository($this->getQueryType($throughId));
	}
	
	public function getFactory($throughId = null)
	{
		return new EloquentFactory($this->getQueryType($throughId));
	}
	
	public function createCommand($throughId = null)
	{
		$command = new CreateOrderCommand($this->getFactory($throughId));
		return $command->setAuth($this->auth);
	}
	
	public function updateCommand($throughId = null)
	{
		throw new \Exception('not implemented');
	}
	public function getSpecificRequest()
	{
		return app(OrderRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new OrderTransformer;
	}
	
	public function getReportTransformer()
	{
		return new OrderTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		$report = new OrderReport($this->getQueryType($throughId));
		
		return $report->isNotVoid()->dontHaveDebt();
	}
	
	public function void($dateRange, Request $request)
    {
    	$report = new OrderReport($this->getQueryType());
    	
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->orderBy()
    							->report(
    								$dateRange, 
    								$report->isVoid(),
    								$this->getReportTransformer()
    							);
    }
    
    public function voidThrough($throughId, $dateRange, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	
    	$report = new OrderReport($this->getQueryType($throughId));
    	
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->orderBy()
						    	->report(
						   			$dateRange,
						    		$report->isVoid(),
						   			$this->getReportTransformer()
						    	);
    }
    
    public function debt($dateRange, Request $request)
    {
    	$report = new OrderReport($this->getQueryType());
    	 
    	return $this->mediator->checkPermission($this->reportAccess)
					    	->setRequest($request)
					    	->setWith()
					    	->setPerPage()
					    	->orderBy()
					    	->report(
					   			$dateRange,
					   			$report->isNotVoid()->haveDebtAndNotSettled(),
					    		$this->getReportTransformer()
					    	);
    }
    
    public function debtThrough($throughId, $dateRange, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	 
    	$report = new OrderReport($this->getQueryType($throughId));
    
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->orderBy()
						    	->report(
						    			$dateRange,
						    			$report->isNotVoid()->haveDebtAndNotSettled(),
						    			$this->getReportTransformer()
						    	);
    }
    
    public function settled($dateRange, Request $request)
    {
    	$report = new OrderReport($this->getQueryType());
    
    	return $this->mediator->checkPermission($this->reportAccess)
					    	->setRequest($request)
					    	->setWith()
					    	->setPerPage()
					    	->orderBy()
					    	->report(
					   			$dateRange,
					   			$report->isNotVoid()->haveDebtAndSettled(),
					   			$this->getReportTransformer()
					   		);
    }
    
    public function settledThrough($throughId, $dateRange, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    
    	$report = new OrderReport($this->getQueryType($throughId));
    
    	return $this->mediator->checkPermission($this->reportAccess)
    	->setRequest($request)
    	->setWith()
    	->setPerPage()
    	->orderBy()
    	->report(
    			$dateRange,
    			$report->isNotVoid()->haveDebtAndSettled(),
    			$this->getReportTransformer()
    			);
    }
	
	public function voidOrder($id, Request $request)
	{
		$query = $this->getRepository();
		
		$command = new UpdateOrderToVoidCommand($query);
		
		$command->setOperator($this->auth->currentUser()->id);
		
		return $this->mediator->checkPermission('void-order')
							->setRequest($request)
							->update(
								$id,
								$command
							);
	}
	
	public function debtOrder($id, DebtRequest $request)
	{
		$query = $this->getRepository();
		
		$command = new UpdateOrderDebtCommand($query);
		
		return $this->mediator->checkPermission('void-order')
							->setRequest($request)
							->update(
								$id,
								$command->makeDebt()
							);
	}
	
	public function debtSettledOrder($id, DebtRequest $request)
	{
		$query = $this->getRepository();
	
		$command = new UpdateOrderDebtCommand($query);
	
		return $this->mediator->checkPermission('void-order')
							->setRequest($request)
							->update(
								$id,
								$command->makeDebtSettled()
							);
	}
	
}
