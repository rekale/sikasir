<?php

namespace Sikasir\V1\Factories;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;

abstract class Factory 
{
	protected $query;
	
	public function __construct(QueryCompanyInterface $query = null)
	{
		$this->query = $query;
	}
	
	/**
	 * 
	 * @param QueryCompanyInterface $query
	 * 
	 * @return $this
	 */
	public function setQuery(QueryCompanyInterface $query)
	{
		$this->query = $query;
		
		return $this;
	}
	
	abstract public function create(array $data);
}