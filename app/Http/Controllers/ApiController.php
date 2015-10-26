<?php

namespace Sikasir\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use \Sikasir\Traits\ApiRespondable;
use \Sikasir\Traits\IdObfuscater;

class ApiController extends Controller
{
    use ApiRespondable, IdObfuscater;
    
    private $request;
    
    public function __construct(Manager $fractal, Request $request) 
    {
        $this->fractal = $fractal;
        
        $this->request = $request;
        
        if ( $request->input('include') ) {
            $this->fractal->parseIncludes( $this->request->input('include') );
        }
    }
   
  
    public function fractal()
    {
        return $this->fractal;
    }
    
    /**
     * get request class
     * 
     * @return Illuminate\Http\Request
     */
    public function request()
    {
        return $this->request;
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
