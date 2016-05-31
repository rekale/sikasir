<?php

namespace Sikasir\V1\Reports;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;

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
		$this->dateRange = explode(',' , $dateRange);

		return $this;
	}

	/**
	 *
	 * @param string $this
	 */
	public function orderBy($value = [])
	{
		//if array is not empty
		if(count($value) > 0 ) {

			$this->query = $this->query->orderBy($value[0], $value[1]);
		}

		return $this;
	}
	abstract function getResultFor($id);

	abstract public function getResult();
}
