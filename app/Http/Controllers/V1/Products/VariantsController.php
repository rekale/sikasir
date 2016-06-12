<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Requests\ProductRequest;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Commands\CreateProductCommand;
use Sikasir\V1\Transformer\VariantTransformer;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\NoCompany;
use Sikasir\V1\Commands\UpdateProductCommand;

class VariantsController extends ApiController
{

	public function initializeAccess()
	{
		$this->indexAccess = 'read-product';
		$this->destroyAccess = 'edit-product';

	}

    public function getQueryType($throughId = null)
    {
    	return new ELoquentThroughCompany(
			new Variant, $this->auth->getCompanyId(), 'products', $throughId 
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
    	$command = new CreateProductCommand($this->getFactory($throughId));

    	return $command->setAuth($this->auth);
    }

    public function updateCommand($throughId = null)
    {
    	$command = new UpdateProductCommand($this->getRepository($throughId));

    	return $command;
    }
    public function getSpecificRequest()
    {
    	return app(ProductRequest::class);
    }


    public function getTransformer()
    {
    	return new VariantTransformer;
    }

    public function getReportTransformer()
    {
    	return new VariantTransformer;
    }


    public function getReport($throughId = null)
    {
    	throw new \Exception('not implemented');
    }

}
