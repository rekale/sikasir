<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait PostAndUpdateable
{
    
    protected $createAccess;
    protected $updateAccess;
    
    public function store()
    {
        $this->currentUser->authorizing($this->createAccess);
        
        $dataInput = Obfuscater::decodeArray($this->request()->all(), 'id');
        
        $factory = $this->getFactory();
        
        $factory->create($dataInput);
        
        return $this->response->created();
    }

    public function update($id)
    {
        $this->currentUser->authorizing($this->updateAccess);
        
        $repo = $this->getRepo();
        
        $entity = $repo->find( Obfuscater::decode($id) );
        
        $updateInput = Obfuscater::decodeArray($this->request()->all());
        
        $entity->update($updateInput);
        
        return $this->response->updated();
    }
}
