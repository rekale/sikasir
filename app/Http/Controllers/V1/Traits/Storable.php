<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
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
        $this->currentUser->authorizing($this->storeAccess);
        
        $factory = $this->getFactory();
        
        $createInput = Obfuscater::decodeArray($this->request()->all(), 'id');
        
        $factory->create($createInput);
        
        return $this->response->created();
    }
}
