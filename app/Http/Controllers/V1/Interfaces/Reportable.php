<?php

namespace Sikasir\Http\Controllers\V1\Interfaces;

use Sikasir\V1\Reports\Report;

interface Reportable 
{
	/**
	 * 
	 * @return Report
	 */
	public function getReport();
}