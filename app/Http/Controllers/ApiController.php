<?php

namespace Sikasir\Http\Controllers;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\Controller;
use Sikasir\Traits\IdObfuscater;
use Sikasir\Traits\ApiRespondable;
use \League\Fractal\Manager;

class ApiController extends Controller
{
    
    use ApiRespondable, IdObfuscater;
   
    protected $fractal;
    
    public function __construct(Manager $fractal) {
        
        $this->fractal = $fractal;
    }
    
   protected function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    }
    
    /**
     * 
     * return data from collection to json
     * 
     * @param \Illuminate\Support\Collection $collection
     * @param Closure $callback
     */
    protected function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);
     
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    }
    
    /**
     * 
     * return data from paginator to json
     * 
     * @param Paginator $paginator
     * @param Closure $callback
     */
    protected function respondWithPaginated($paginator, $callback)
    {
    
        $collection = $paginator->getCollection();
        
        $resource = new Collection($collection, $callback);
        
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    
    }
}
