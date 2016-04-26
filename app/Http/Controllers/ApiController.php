<?php

namespace Sikasir\Http\Controllers;

use Sikasir\Http\Controllers\Controller;
use Sikasir\V1\Traits\ApiRespond;
use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\Mediators\APIMediator;
use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Commands\UpdateCommand;
use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;
use Sikasir\V1\Reports\Report;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\User\Authorizer;

/**
 * 
 * @author M.Haikal
 * Base Class for controller that handle API request
 *
 */
abstract class ApiController extends Controller
{
    /**
     *
     * @var AuthInterface 
     */
    protected $auth;
    
    protected $mediator;
    
    protected $indexAccess;
    protected $showAccess;
    protected $storeAccess;
    protected $updateAccess;
    protected $destroyAccess;
    protected $reportAccess;
	
    /**
     * 
     * @param ReportInterface $auth
     * @param ApiRespond $response
     */
    public function __construct(AuthInterface $auth, ApiRespond $respond) 
    {   
    	
    	$currentUser = $auth->currentUser();
    	
    	$this->mediator = new APIMediator(new Authorizer($currentUser), $respond);
    	
    	$this->auth = $auth;
    	
        $this->initializeAccess();
        /*
        if(config('database.default') === 'mysql') {
        	\DB::listen(function($sql, $bindings, $time) {
        		var_dump($sql);
        		var_dump($time);
        	});
        }
        */
    }
    
    public function index(Request $request)
    {
    	return $this->mediator->checkPermission($this->indexAccess)
    							->setRequest($request)
    							->setWith()
    							->setPerPage()
    							->orderBy()
						    	->index(
					    			$this->getRepository(),
					    			$this->getTransformer()
				    			);
    
    }
    
    public function indexThrough($id, Request $request)
    {
    	$throughId = Obfuscater::decode($id);
    	
    	return $this->mediator->checkPermission($this->indexAccess)
						    	->setRequest($request)
    							->setWith()
    							->setPerPage()
    							->orderBy()
						    	->index(
						    		$this->getRepository($throughId),
						   			$this->getTransformer()
						    	);
    
    }
    
    public function show($id,Request $request)
    {
    	return $this->mediator->checkPermission($this->showAccess)
					    		->setRequest($request)
    							->setWith()
    							->show(
					    			$id,
					    			$this->getRepository(),
					    			$this->getTransformer()
				    			);
    }
    
    public function showThrough($throughId, $id, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	
    	return $this->mediator->checkPermission($this->showAccess)
    							->setRequest($request)
						    	->setWith()
						    	->show(
						    			$id,
						    			$this->getRepository($throughId),
						    			$this->getTransformer()
						    	);
    }
    
    public function store()
    {
    
    	$command = $this->createCommand();
    
    	return $this->mediator->checkPermission($this->storeAccess)
    							->setRequest($this->getSpecificRequest())
    							->store($command);
    
    }
    
    public function storeThrough($throughId)
    {
    	$id = Obfuscater::decode($throughId);
    	
    	$command = $this->createCommand($id);
    
    	return $this->mediator->checkPermission($this->storeAccess)
    							->setRequest($this->getSpecificRequest())
    							->store($command);
    
    }
	
    
    public function update($id)
    {
    	$command = $this->updateCommand();
    	
    	return $this->mediator->checkPermission($this->updateAccess)
    							->setRequest($this->getSpecificRequest())
    							->update(
    								$id, 
    								$command
    							);
    }
    
    public function updateThrough($throughId, $id)
    {
    	$throughId = Obfuscater::decode($throughId);
    	 
    	$command = $this->updateCommand($throughId);
    	 
    	return $this->mediator->checkPermission($this->updateAccess)
    						->setRequest($this->getSpecificRequest())
					    	->update(
					    		$id,
					   			$command
					   		);
    }
    
    public function destroy($id)
    {
    	return $this->mediator->checkPermission($this->destroyAccess)
    							->destroy(
    								$id, 
    								$this->getRepository()
    							);
    }
    
    public function destroyThrough($throughId, $id)
    {
    	$throughId = Obfuscater::decode($throughId);
    	
    	return $this->mediator->checkPermission($this->destroyAccess)
				    			->destroy(
				    				$id,
				    				$this->getRepository($throughId)
				    			);
    }
    
    public function report($dateRange, Request $request)
    {
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->orderBy()
    							->report(
    								$dateRange, 
    								$this->getReport(),
    								$this->getReportTransformer()
    							);
    }
    
    public function reportThrough($throughId, $dateRange, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	 
    	return $this->mediator->checkPermission($this->reportAccess)
		    	->setRequest($request)
		    	->setWith()
		    	->setPerPage()
		    	->orderBy()
		    	->report(
	    			$dateRange,
	    			$this->getReport($throughId),
	    			$this->getReportTransformer()
    			);
    }
    
    public function reportFor($id, $dateRange, Request $request)
    {
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->reportFor(
						    		$id,
						   			$dateRange,
						   			$this->getReport(),
						   			$this->getReportTransformer()
						    	);
    }
    
    public function search($field, $param, Request $request)
    {
    	return $this->mediator->checkPermission($this->indexAccess)
					    		->setRequest($request)
					    		->setWith()
					    		->setPerPage()
					    		->orderBy()
    						  	->search(
    						  		$this->getRepository(),
    						  		$field,
    						  		$param,
    						  		$this->getTransformer()
    						  	);
    }
    
    public function searchThrough($throughId, $field, $param, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	
    	return $this->mediator->checkPermission($this->indexAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->orderBy()
						    	->setPerPage()
						    	->search(
						    			$this->getRepository($throughId),
						    			$field,
						    			$param,
						    			$this->getTransformer()
						    			);
    }
    
    /**
     * for intializing access variable from traits
     * 
     * @return void
     */
    abstract public function initializeAccess();
    
    /**
     * 
     * @return RepositoryInterface
     */
    abstract public function getRepository($troughId = null);
    
    /**
     * 
     * @return TransformerAbstract
     */
    abstract  public function getTransformer();
    
    /**
     *
     * @return TransformerAbstract
     */
    abstract  public function getReportTransformer();
    
    /**
     * 
     * @return CreateCommand
     */
    abstract  public function createCommand($troughId = null);
    
    /**
     *
     * @return UpdateCommand
     */
    abstract  public function updateCommand($troughId = null);
    
    /**
     * 
     * @return Request
     */
    abstract  public function getSpecificRequest();
    
    /**
     * 
     * @return Report
     */
    abstract  public function getReport($troughId = null);
    
}
