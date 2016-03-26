<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\User\Authorizer;
/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait Storable
{
    
    protected $storeAccess;

    public function store()
    {

    	(new Authorizer($this->auth->currentUser()))->checkAccess($this->storeAccess);
        
        $data = Obfuscater::decodeArray($this->getRequest()->all(), 'id');
        
        $this->createJob($data);
        
        return $this->response->created();
    }
}
