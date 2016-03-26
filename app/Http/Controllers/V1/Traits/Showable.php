<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\User\Authorizer;
/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait Showable
{
    protected $showAccess;
    
    public function show($id)
    {   
        (new Authorizer($this->auth->currentUser()))->checkAccess($this->showAccess);
        
        $include = request('include');
        
        $with = $this->filterIncludeParams($include);
        
        $repository = $this->getRepo();
        
        $item = $repository->findWith(Obfuscater::decode($id), $with);
        
        return $this->response
                ->resource()
                ->including($with)
                ->withItem($item, $this->getTransformer());
        
    }
    
}
