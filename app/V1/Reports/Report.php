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
	 * @param integer $id
	 *
	 * @return Builder
	 */
	public function forInstanceWithId($id)
	{
		$this->query = $this->query->findOrFail($id);
	
		return $this;
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
	
	abstract public function getResult();
}