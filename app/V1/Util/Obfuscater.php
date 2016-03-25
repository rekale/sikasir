<?php


namespace Sikasir\V1\Util;

final class Obfuscater {
    
    private static $salt = 'dDLZyl93F8TnO0GAw1riV5b4QoKsc2vx6tMeYmI7pNBXauWJqkjPCgSEfHhURz';
    
    /**
     *  encode the id
     * 
     * @param type string|array $id
     * @return string|array
     */
    public static function encode($id)
    {
        $tiny = new \ZackKitzmiller\Tiny(self::$salt);
        
        if (is_array($id)) {
            
            $decodedId = [];
            
            foreach ($id as $name => $encodedId) {
                $decodedId[$name] = $tiny->to($encodedId);
            }
            
            return $decodedId;
        }
        
        return $tiny->to($id);
    }
    
    public static function decodeArray(array $data, $keyword)
    {
        $tiny = new \ZackKitzmiller\Tiny(self::$salt);
        
        foreach ($data as $name => $currentData) {
            
            //if current data is an array, make recursion
            if(is_array($currentData)) {
                $data[$name] = self::decodeArray($currentData, $keyword);
            }
            
            
            //decode only from name that have similiar string with keyword
            else if ( isset($currentData) && strpos($name, $keyword) !== false) {
            	
            	$data[$name] = $tiny->from($currentData);
        
            }
            
        }
        
        return $data;
    }
    
    /**
     * decode the encoded id
     * 
     * @param type string|array $id
     * @return string|array
     */
    public static function decode($id)
    {
        $tiny = new \ZackKitzmiller\Tiny(self::$salt);
        
        if (is_array($id)) {
            
            $decodedId = [];
            
            foreach ($id as $name => $encodedId) {
                $decodedId[$name] = $tiny->from($encodedId);
            }
            
            return $decodedId;
        }
        
        return $tiny->from($id);
    }
    
    public static function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }
}
