<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Requests\PaymentRequest;
use Sikasir\V1\Transformer\PaymentTransformer;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Transactions\Payment;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Reports\PaymentReport;

class PaymentsController extends TempApiController
{
public function initializeAccess()
	{
		$this->indexAccess = 'read-payment';
		$this->showAccess = 'read-payment';
		$this->destroyAccess = 'delete-payment';
	
		$this->storeAccess = 'create-payment';
		$this->updateAccess = 'update-payment';
		$this->reportAccess = 'read-payment';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Payment, $this->auth->getCompanyId());
	}
	
	public function getRepository()
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory()
	{
		$queryType = new EloquentCompany(new Payment, $this->auth->getCompanyId());
	
		return new EloquentFactory($queryType);
	}
	
	public function createCommand()
	{
		$factory =  new EloquentFactory($this->getQueryType());
		
		return new GeneralCreateCommand($factory);
	}
	
	public function updateCommand()
	{
		return new GeneralUpdateCommand($this->getRepository());
	}
	public function getSpecificRequest()
	{
		return app(PaymentRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new PaymentTransformer;
	}
	
	public function getReportTransformer()
	{
		return new PaymentTransformer;
	}
	
	
	public function getReport()
	{
		return new PaymentReport($this->getQueryType());
	}

}
