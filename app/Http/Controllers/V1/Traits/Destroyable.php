<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\User\Authorizer;
/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait Destroyable
{
    protected $destroyAccess;
    
    public function destroy($id)
    {
    	(new Authorizer($this->auth->currentUser()))->checkAccess($this->destroyAccess);
        
        $repo = $this->getRepo();
        
        $repo->destroy(Obfuscater::decode($id));
        
        return $this->response->deleted();
    }
    
}
