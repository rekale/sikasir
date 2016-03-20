<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
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
        $this->currentUser->authorizing($this->deleteAccess);
        
        $repo = $this->getRepo();
        
        $repo->destroy(Obfuscater::decode($id));
        
        return $this->response->deleted();
    }
    
}
