<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Traits;

/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait IdObfuscater 
{
    
    private $salt = 'dDLZyl93F8TnO0GAw1riV5b4QoKsc2vx6tMeYmI7pNBXauWJqkjPCgSEfHhURz';
    
    
    /**
     *  encode the id
     * 
     * @param type string|array $id
     * @return string|array
     */
    protected function encode($id)
    {
        $tiny = new \ZackKitzmiller\Tiny($this->salt);
        
        if (is_array($id)) {
            
            $decodedId = [];
            
            foreach ($id as $name => $encodedId) {
                $decodedId[$name] = $tiny->to($encodedId);
            }
            
            return $decodedId;
        }
        
        return $tiny->to($id);
    }
    
    /**
     * decode the encoded id
     * 
     * @param type string|array $id
     * @return string|array
     */
    protected function decode($id)
    {
        $tiny = new \ZackKitzmiller\Tiny($this->salt);
        
        if (is_array($id)) {
            
            $decodedId = [];
            
            foreach ($id as $name => $encodedId) {
                $decodedId[$name] = $tiny->from($encodedId);
            }
            
            return $decodedId;
        }
        
        return $tiny->from($id);
    }
    
}
