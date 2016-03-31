<?php

namespace Sikasir\V1\Reports;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;
use Illuminate\Database\Query\Builder;

abstract class Report 
{
	protected $dateRange;
	
	protected $query;
	

	/**
	 *
	 * @param QueryCompanyInterface $query
	 *
	 */
	public function __construct(QueryCompanyInterface $query)
	{
		$this->query = $query->forCompany();
	
	}
	
	/**
	 * 
	 * @param string $dateRange
	 * 
	 * @return $this
	 */
	public function whenDate($dateRange)
	{
		$this->dateRange = explode(',' , str_replace(' ', '', $dateRange));
		
		return $this;
	}
	
	/**
	 * 
	 * @param integer $id
	 */
	abstract function getResultFor($id);
	
	abstract public function getResult();
}