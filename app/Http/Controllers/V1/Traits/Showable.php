<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
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
        $this->currentUser->authorizing($this->showAccess);
        
        $include = request('include');
        
        $with = $this->filterIncludeParams($include);
        
        $repository = $this->getRepo();
        
        $outlets = $repository->findWith(Obfuscater::decode($id), $with);
        
        return $this->response
                ->resource()
                ->including($with)
                ->withItem($outlets, $this->getTransformer());
        
    }
    
}
