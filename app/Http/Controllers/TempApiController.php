<?php

namespace Sikasir\Http\Controllers;

use Sikasir\Http\Controllers\Controller;
use Sikasir\V1\Traits\ApiRespond;
use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Sikasir\V1\Interfaces\AuthInterface;

/**
 * 
 * @author M.Haikal
 * Base Class for controller that handle API request
 *
 */
abstract class TempApiController extends Controller
{
    /**
     *
     * @var AuthInterface 
     */
    protected $auth;
    
   /**
    *
    * @var ApiRespond 
    */
    protected $response;
    
    /**
     *
     * @var TransformerAbstract
     */
    private $transformer;
	
    /**
     * 
     * @param ReportInterface $auth
     * @param ApiRespond $response
     */
    public function __construct(AuthInterface $auth, ApiRespond $response) 
    {    
        $this->auth = $auth;
        $this->response = $response;  
        
        $this->initializeAccess();
    }
    
    /**
     * for intializing access variable from traits
     * 
     * @return void
     */
    abstract public function initializeAccess();
    
    abstract  public function getQueryType($throughId = null);
    
    
    public function filterIncludeParams($param)
    {
        $paramsinclude  = [];
        
        
        if (! is_null($param)) {
            //remove the whitespace
            $param = str_replace(' ', '', $param);
        
            foreach (explode(',', $param) as $data) {
                $paramsinclude[]  = $data;
            }
        }
        
        return $paramsinclude;
    }
}
