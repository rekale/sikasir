<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;

/**
 *
 *
 * @author rekale
 */
trait Reportable
{
    
    protected $reportAccess;
    
    public function report($dateRange)
    {
        
        $this->currentUser->authorizing($this->reportAccess);
        
        $include = request('include');
        
        $with = $this->filterIncludeParams($include);
        
        
        $giveReport = $this->getReport();
        
        $report = $giveReport->whenDate($dateRange)
        					->getResult()
        					->paginate();
        
        return $this->response
                ->resource()
                ->including($with)
                ->withPaginated($report, $this->getTransformer());
    }
    
    public function reportFor($id, $dateRange)
    {
    
    	$this->currentUser->authorizing($this->reportAccess);
    
    	$include = request('include');
    
    	$with = $this->filterIncludeParams($include);
    
    	$giveReport = $this->getReport();
    
    	$report = $giveReport->whenDate($dateRange)
    						->forInstanceWithId( Obfuscater::decode($id) )
    						->getResult()
    						->paginate();
    
    	return $this->response
			    	->resource()
			    	->including($with)
			    	->withPaginated($report, $this->getReportTransformer());
    }

}
