<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Traits;

use \League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use \League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;
use Illuminate\Http\JsonResponse;

class ApiRespond 
{
    
     private $statusCode = 200;
     private $fractal;
     
     
     /**
      * response resource or data
      * 
      * @return $this
      */
     public function resource()
     {
         $this->fractal = new Manager;
         
         return $this;
     }
     
     /**
      * include for fractal
      * 
      * @param type $include
      * @return $this
      */
     public function including($include = null)
     {
         
        $included = isset($include) ? $include : 
                filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        if (isset($included)) {
             $this->fractal->parseIncludes($included);
         }
         
         return $this;
     }
     
    /**
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
    public function notFound($msg = 'Not Found')
    {
        return $this->setStatusCode(404)->withError($msg);
    }
    
    /**
     * user not authorized
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function notAuthorized($msg = 'Not Authorized')
    {
        return $this->setStatusCode(403)->withError($msg);
    }
    
    /**
     * response input is not proccesable
     * 
     * @param type $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function inputNotProcessable($msg)
    {
        return $this->setStatusCode(422)->withError($msg);
    }
    
    /**
     * resource successfuly created
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function created($msg = 'created')
    {
        return $this->setStatusCode(201)->success($msg);
    }
    
    /**
     * resource successfuly updated
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function updated($msg = 'updated')
    {
        return $this->setStatusCode(200)->success($msg);
    }
    
    /**
     * resource successfuly deleted
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleted($msg = 'deleted')
    {
        return $this->setStatusCode(200)->success($msg);
    }
    
    /**
     * resource failed to create
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFailed($msg = 'fail to create')
    {
        return $this->setStatusCode(409)->withError($msg);
    }
    
    /**
     * return success message
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($msg)
    {
        return $this->respond([
            'success' => [
                'message' => $msg,
                'code' => $this->getStatusCode(),
            ]
        ]);
    }
    
    /**
     * return error message
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function withError($msg)
    {
        return $this->respond([
            'error' => [
                'message' => $msg,
                'code' => $this->getStatusCode(),
            ]
        ]);
    }
    
    /**
     * make respond
     * 
     * @param string $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers=[])
    {
        return new JsonResponse($data, $this->getStatusCode(), $headers);
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
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function withPaginated($paginator, TransformerAbstract $callback)
    {
        $collection = $paginator->getCollection();
        
        $resource = new Collection($collection, $callback);
        
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    
    }
    
    /**
     * 
     * return data from one collection to json
     * 
     * @param Static $item
     * @param \League\Fractal\TransformerAbstract $callback
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function withItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    }
    
}
