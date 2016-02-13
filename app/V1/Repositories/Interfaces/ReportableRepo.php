<?php

namespace Sikasir\V1\Repositories\Interfaces;

interface ReportableRepo
{
    /**
     * 
     * @param integer $companyId
     * @param array $dateRange
     * @param integer|null $outletId
     * @param integer $perPage
     */
    public function getReportsForCompany($companyId, $dateRange, $outletId = null, $perPage = 15);
}
