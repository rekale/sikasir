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
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;
use Sikasir\V1\Reports\Report;
use Sikasir\V1\Util\Obfuscater;

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
    public function __construct(APIMediator $mediator, AuthInterface $auth) 
    {   
    	$this->mediator = $mediator;
    	
    	$this->auth = $auth;
    	
        $this->initializeAccess();
        
        if(config('database.default') === 'mysql') {
        	\DB::listen(function($sql, $bindings, $time) {
        		var_dump($sql);
        		var_dump($time);
        	});
        }
    }
    
    public function index(Request $request)
    {
    	return $this->mediator->checkPermission($this->indexAccess)
						    	->index(
					    			$this->getRepository(),
					    			$request,
					    			$this->getTransformer()
				    			);
    
    }
    
    public function indexThrough($id, Request $request)
    {
    	$throughId = Obfuscater::decode($id);
    	
    	return $this->mediator->checkPermission($this->indexAccess)
						    	->index(
						    		$this->getRepository($throughId),
						   			$request,
						   			$this->getTransformer()
						    	);
    
    }
    
    public function show($id,Request $request)
    {
    	return $this->mediator->checkPermission($this->showAccess)
					    	->show(
				    			$id,
				    			$this->getRepository(),
				    			$request,
				    			$this->getTransformer()
			    			);
    }
    
    public function showThrough($throughId, $id, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	
    	return $this->mediator->checkPermission($this->showAccess)
    	->show(
    			$id,
    			$this->getRepository($throughId),
    			$request,
    			$this->getTransformer()
    			);
    }
    
    public function store()
    {
    
    	$command = $this->createCommand();
    
    	return $this->mediator->checkPermission($this->storeAccess)
    							->store(
    								$command, 
    								$this->getSpecificRequest()
    							);
    
    }
    
    public function storeThrough($throughId)
    {
    	$id = Obfuscater::decode($throughId);
    	
    	$command = $this->createCommand($id);
    
    	return $this->mediator->checkPermission($this->storeAccess)
    							->store(
    								$command,
    								$this->getSpecificRequest()
    							);
    
    }
	
    
    public function update($id)
    {
    	$command = $this->updateCommand();
    	
    	return $this->mediator->checkPermission($this->updateAccess)
    							->update(
    								$id, 
    								$command, 
    								$this->getSpecificRequest()
    							);
    }
    
    public function updateThrough($throughId, $id)
    {
    	$throughId = Obfuscater::decode($throughId);
    	 
    	$command = $this->updateCommand($throughId);
    	 
    	return $this->mediator->checkPermission($this->updateAccess)
					    	->update(
					    		$id,
					   			$command,
					   			$this->getSpecificRequest()
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
    							->report(
    								$dateRange, 
    								$this->getReport(), 
    								$request, 
    								$this->getReportTransformer()
    							);
    }
    
    public function reportFor($id, $dateRange, Request $request)
    {
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->reportFor(
						    		$id,
						   			$dateRange,
						   			$this->getReport(),
						   			$request,
						   			$this->getReportTransformer()
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
