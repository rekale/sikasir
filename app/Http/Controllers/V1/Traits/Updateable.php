<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\User\Authorizer;
/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait Updateable
{
    protected $updateAccess;

    public function update($id)
    {
    	( new Authorizer($this->auth->currentUser()) )->checkAccess($this->updateAccess);
        
    	$data = Obfuscater::decodeArray($this->getRequest()->all(), 'id');
    	
    	$this->updateJob(Obfuscater::decode($id), $data);
        
        return $this->response->updated();
    }
}
