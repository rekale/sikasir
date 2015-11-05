<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\Traits;

use \League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use \League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class ApiRespond 
{
    
     private $statusCode = 200;
     private $fractal;
     
     public function __construct(Manager $fractal) {
         $this->fractal = $fractal;
     }
     
     /**
      * include for fractal
      * 
      * @param type $include
      * @return $this
      */
     public function including($include)
     {
         $this->fractal->parseIncludes($include);
         
         return $this;
     }
     
    
     public function getStatusCode()
     {
         return $this->statusCode;
     }

     /**
    * set status code
    * 
    * @return $this
    */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        
        return $this;
    }
    
    /**
     * resource not found
     * 
     * @param string $msg
     */
    public function notFound($msg = 'Not Found')
    {
        return $this->setStatusCode(404)->withError($msg);
    }
    
    /**
     * resource successfuly created
     * 
     * @param string $msg
     */
    public function created($msg = 'created')
    {
        return $this->setStatusCode(201)->success($msg);
    }
    
    /**
     * resource failed to create
     * 
     * @param string $msg
     */
    public function createFailed($msg = 'fail to create')
    {
        return $this->setStatusCode(409)->withError($msg);
    }
    
    
    public function success($msg)
    {
        return $this->respond([
            'success' => [
                'message' => $msg,
                'code' => $this->getStatusCode(),
            ]
        ]);
    }
    
    public function withError($msg)
    {
        return $this->respond([
            'error' => [
                'message' => $msg,
                'code' => $this->getStatusCode(),
            ]
        ]);
    }


    public function respond($data, $headers=[])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }
    
    /**
     * 
     * return data from collection to json
     * 
     * @param \Illuminate\Support\Collection $collection
     * @param Closure $callback
     */
    public function withCollection($collection, $callback)
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
     * @param \League\Fractal\TransformerAbstract $callback
     */
    public function withPaginated($paginator, TransformerAbstract $callback)
    {
    
        $collection = $paginator->getCollection();
        
        $resource = new Collection($collection, $callback);
        
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    
    }
    
    public function withItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    }
    
}
