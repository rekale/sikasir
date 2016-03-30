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
			$this->indexAccess = 'read-settings';
		$this->showAccess = 'read-settings';
		$this->destroyAccess = 'edit-settings';
	
		$this->storeAccess = 'edit-settings';
		$this->updateAccess = 'edit-settings';
		$this->reportAccess = 'edit-settings';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Payment, $this->auth->getCompanyId());
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory($throughId = null)
	{
		return new EloquentFactory($this->getQueryType());
	}
	
	public function createCommand($throughId = null)
	{	
		return new GeneralCreateCommand($this->getFactory());
	}
	
	public function updateCommand($throughId = null)
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
	
	
	public function getReport($throughId = null)
	{
		return new PaymentReport($this->getQueryType());
	}

}
