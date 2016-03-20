<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
/**
 * Description of ObfuscaterId
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
                ->withPaginated($outlets, $this->transformer);
    }

}
