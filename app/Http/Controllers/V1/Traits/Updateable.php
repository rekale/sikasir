<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
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
        $this->currentUser->authorizing($this->updateAccess);
        
        $repo = $this->getRepo();
        
        $entity = $repo->find( Obfuscater::decode($id) );
        
        $updateInput = Obfuscater::decodeArray($this->getRequest()->all(), 'id');
        
        $entity->update($updateInput);
        
        return $this->response->updated();
    }
}
