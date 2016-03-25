<?php

namespace Sikasir\V1\Factories;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;

abstract class Factory 
{
	protected $query;
	
	public function __construct(QueryCompanyInterface $query)
	{
		$this->query = $query;
	}
	
	abstract public function create(array $data);
}