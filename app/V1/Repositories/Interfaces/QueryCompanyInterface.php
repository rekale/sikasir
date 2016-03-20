<?php

namespace Sikasir\V1\Repositories\Interfaces;
use Illuminate\Database\Query\Builder;

interface QueryCompanyInterface 
{
    /**
     * speciify how to get item only for speoific company
     * 
     * Builder
     */
    public function forCompany();
    
    /**
     * prepare data
     * 
     * return array
     */
    public function dataForCompany(array $data);
}
