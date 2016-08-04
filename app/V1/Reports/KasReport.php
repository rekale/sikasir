<?php

namespace Sikasir\V1\Reports;

class KasReport extends Report
{
	public function getResult()
	{
		return $this->query
					->whereBetween('created_at', $this->dateRange);
	}

	public function getResultFor($id)
	{
		throw new Exception('not implemented');
	}

}
