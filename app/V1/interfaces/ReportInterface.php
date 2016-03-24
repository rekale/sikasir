<?php

namespace Sikasir\V1\interfaces;


use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;

interface ReportInterface 
{
	/**
	 * 
	 * @param QueryCompanyInterface $query
	 * @param string $dateRange
	 */
	public function report(QueryCompanyInterface $query, $dateRange);
}