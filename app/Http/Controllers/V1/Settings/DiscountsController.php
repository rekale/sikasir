<?php

namespace Sikasir\Http\Controllers\V1\Settings;


use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\V1\Transformer\DiscountTransformer;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Outlets\Discount;

class DiscountsController extends ApiController
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
		return  new EloquentCompany(new Discount, $this->auth->getCompanyId());
	}

	public function getRepository($throughId = null)
	{
		return new EloquentRepository($this->getQueryType());
	}

	public function getFactory($throughId = null)
	{
		$queryType = new EloquentCompany(new Discount, $this->auth->getCompanyId());

		return new EloquentFactory($queryType);
	}

	public function createCommand($throughId = null)
	{
		$factory =  new EloquentFactory($this->getQueryType());

		return new GeneralCreateCommand($factory);
	}

	public function updateCommand($throughId = null)
	{
		return new GeneralUpdateCommand($this->getRepository());
	}
	public function getSpecificRequest()
	{
		return app(TaxDiscountRequest::class);
	}


	public function getTransformer()
	{
		return new DiscountTransformer;
	}

	public function getReportTransformer()
	{
		return new DiscountTransformer;
	}


	public function getReport($throughId = null)
	{
		return new CustomerReport($this->getQueryType());
	}

}
