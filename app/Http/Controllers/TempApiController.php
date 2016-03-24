<?php

namespace Sikasir\Http\Controllers;

use Sikasir\Http\Controllers\Controller;
use Sikasir\V1\Interfaces\CurrentUser;
use Sikasir\V1\Traits\ApiRespond;
use League\Fractal\TransformerAbstract;
use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;
use Sikasir\V1\Factories\EloquentFactory;
use Illuminate\Http\Request;

abstract class TempApiController extends Controller
{
    /**
     *
     * @var CurrentUser 
     */
    protected $currentUser;
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

    public function __construct(CurrentUser $user, ApiRespond $response) 
    {    
        $this->currentUser = $user;
        $this->response = $response;  
        
        $this->initializeAccess();
    }
    
    /**
     * for intializing access variable from trait Gettable and PostAndUpdateable
     * 
     * @return void
     */
    abstract public function initializeAccess();
    
    /**
     * get repository instance
     * 
     * @return RepositoryInterface 
     */
    abstract public function getRepo();
    
    /**
     * get factory instance
     * 
     * @return EloquentFactory 
     */
    abstract public function getFactory();
    
    /**
     * get the request
     * 
     * @return Request
     */
    abstract public function getRequest();
    
    /**
     * set the transformer
     * 
     * @return TransformerAbstract
     */
    abstract public function getTransformer();
    
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
