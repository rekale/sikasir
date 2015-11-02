<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\Traits;

/**
 * Description of ApiRrespondTrait
 *
 * @author rekale
 */
trait ApiRespondable 
{
    
     private $fractal;
     private $statusCode = 200;
    
    /**
    * get current status code, default is 200
    * 
    * @return integer
    */
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
    protected function respondNotFound($msg = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($msg);
    }
    
    /**
     * resource successfuly created
     * 
     * @param string $msg
     */
    protected function respondCreated($msg = 'created')
    {
        return $this->setStatusCode(201)->respondSuccess($msg);
    }
    
    /**
     * resource failed to create
     * 
     * @param string $msg
     */
    protected function respondCreateFailed($msg = 'fail to create')
    {
        return $this->setStatusCode(409)->respondWithError($msg);
    }
    
    
    protected function respondSuccess($msg)
    {
        return $this->respond([
            'success' => [
                'message' => $msg,
                'code' => $this->getStatusCode(),
            ]
        ]);
    }
    
    protected function respondWithError($msg)
    {
        return $this->respond([
            'error' => [
                'message' => $msg,
                'code' => $this->getStatusCode(),
            ]
        ]);
    }


    protected function respond($data, $headers=[])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
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
