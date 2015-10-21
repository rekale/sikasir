<?php

namespace Sikasir\Http\Controllers;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $fractal;
    private $statusCode = 200;
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
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        
        return $this;
    }
    
    protected function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    }
    
    protected function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);
        
        $rootScope = $this->fractal->createData($resource);
        
        return $this->respond($rootScope->toArray()); 
    }
    
    protected function respondNotFound($msg = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($msg);
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
    
}
