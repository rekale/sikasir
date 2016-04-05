<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\ProductRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Requests\ProductRequest;
use Sikasir\V1\Transformer\ProductTransformer;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Reports\ProductReport;
use Sikasir\V1\Util\Obfuscater;
use Illuminate\Http\Request;

class ProductsController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-product';
		$this->reportAccess = 'read-report';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new Product, $this->auth->getCompanyId(), 'outlets', $throughId
		);
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType($throughId));
	}
	
	public function getFactory($throughId = null)
	{
		throw new \Exception('not implemented');
	}
	
	public function createCommand($throughId = null)
	{
		throw new \Exception('not implemented');
	}
	
	public function updateCommand($throughId = null)
	{
		throw new \Exception('not implemented');
	}
	public function getSpecificRequest()
	{
		return app(ProductRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new ProductTransformer;
	}
	
	public function getReportTransformer()
	{
		return new ProductTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		return new ProductReport($this->getQueryType($throughId));
	}
	
	public function bestSeller($dateRange, Request $request)
	{
		$report = new ProductReport($this->getQueryType());
		
		return $this->mediator->checkPermission($this->reportAccess)
							->setRequest($request)
							->setWith()
							->setPerPage()
							->orderBy()
							->report(
								$dateRange,
								$report->bestSeller(),
								$this->getReportTransformer()
							);
	}
	
	public function bestSellerThrough($throughId, $dateRange, Request $request)
	{
		$throughId = Obfuscater::decode($throughId);
		$report = new ProductReport($this->getQueryType($throughId));
	
		return $this->mediator->checkPermission($this->reportAccess)
								->setRequest($request)
								->setWith()
								->setPerPage()
								->orderBy()
								->report(
									$dateRange,
									$report->bestSeller(),
									$this->getReportTransformer()
								);
	}
}
