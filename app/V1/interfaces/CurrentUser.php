<?php

namespace Sikasir\V1\Interfaces;

interface CurrentUser 
{
    /**
     * speicify how to get item only for speoific company
     * 
     * @param string $doThis 
     */
    public function authorizing($doThis);
    
    public function getCompanyId();
}
