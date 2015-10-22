<?php

namespace Sikasir\Http\Controllers\Finances;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Finances\Income;
use Sikasir\Transformer\IncomeTransformer;

class IncomesController extends ApiController
{
    
    public function destroy($id)
    {
        $deleted = Income::destroy($id);
        
        return $this->respondSuccess('selected income has deleted');
    }
  
}
