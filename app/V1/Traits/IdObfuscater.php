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
    
    protected function encode($id)
    {
        $tiny = new \ZackKitzmiller\Tiny($this->salt);
        
        return $tiny->to($id);
    }
    
    
    protected function decode($id)
    {
        $tiny = new \ZackKitzmiller\Tiny($this->salt);
        
        return $tiny->from($id);
    }
    
}
