<?php

namespace Sikasir\Http\Controllers\V1\Settings;


use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Interfaces\CurrentUser;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Outlets\Discount;
use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\V1\Transformer\TaxTransformer;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Storable;

class DiscountsController extends TempApiController
{
	use Showable, Destroyable, Updateable, Storable;
	
	public function __construct(CurrentUser $user, ApiRespond $response)
	{
		parent::__construct($user, $response);
	
	}
	
	public function getRepo()
	{
		$queryType = new EloquentCompany(new Discount, $this->currentUser->getCompanyId());
	
		return new TempEloquentRepository($queryType);
	}
	
	public function getFactory()
	{
		$queryType = new EloquentCompany(new Discount, $this->currentUser->getCompanyId());
	
		return new EloquentFactory($queryType);
	}
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-discount';
		$this->showAccess = 'read-discount';
		$this->deleteAccess = 'delete-discount';
	
		$this->storeAccess = 'create-discount';
		$this->updateAccess = 'update-discount';
	}
	
	public function getRequest()
	{
		return app(TaxDiscountRequest::class);
	}
	
	public function getTransformer()
	{
		return new TaxTransformer;
	}
   
}
