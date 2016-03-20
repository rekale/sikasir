<?php

namespace Sikasir\Http\Controllers\V1\Traits;

use Sikasir\V1\Util\Obfuscater;
/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait Gettable
{
    
    protected $indexAccess;
    protected $showAccess;
    protected $deleteAccess;
    
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
                ->withItem($outlets, $this->transformer);
        
    }
    
    public function destroy($id)
    {
        $this->currentUser->authorizing($this->deleteAccess);
        
        $repo = $this->getRepo();
        
        $repo->destroy(Obfuscater::decode($id));
        
        return $this->response->deleted();
    }
    
    private function filterIncludeParams($param)
    {
        $paramsinclude  = [];
        
        
        if (! is_null($param)) {
            //remove the whitespace
            $param = str_replace(' ', '', $param);
        
            foreach (explode(',', $param) as $data) {
                $paramsinclude[]  = $data;
            }
        }
        
        return $paramsinclude;
    }
}
