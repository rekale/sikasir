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
trait ApiRrespondTrait {
    
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
}
