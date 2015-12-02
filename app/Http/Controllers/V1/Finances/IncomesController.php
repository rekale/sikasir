<?php

namespace Sikasir\Http\Controllers\V1\Finances;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Finances\Income;
use Sikasir\V1\Transformer\IncomeTransformer;

class IncomesController extends ApiController
{
    
    public function destroy($id)
    {
        $deleted = Income::destroy($id);
        
        return $this->response->success('selected income has deleted');
    }
  
}
