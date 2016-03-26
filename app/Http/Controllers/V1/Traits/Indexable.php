<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\User\Authorizer;

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
        
        (new Authorizer($this->auth->currentUser()))->checkAccess($this->indexAccess);
        
        $include = request('include');
        
        $with = $this->filterIncludeParams($include);
        
        $repository = $this->getRepo();
        
        $collection = $repository->getPaginated($with);
        
        return $this->response
                ->resource()
                ->including($with)
                ->withPaginated($collection, $this->getTransformer());
    }

}
