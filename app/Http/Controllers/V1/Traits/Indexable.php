<?php

namespace Sikasir\Http\Controllers\V1\Traits;

/**
 *
 *
 * @author rekale
 */
trait Indexable
{
    
    protected $indexAccess;
    
    public function index()
    {
        
        $this->currentUser->authorizing($this->indexAccess);
        
        $include = request('include');
        
        $with = $this->filterIncludeParams($include);
        
        $repository = $this->getRepo();
        
        $outlets = $repository->getPaginated($with);
        
        return $this->response
                ->resource()
                ->including($with)
                ->withPaginated($outlets, $this->getTransformer());
    }

}
