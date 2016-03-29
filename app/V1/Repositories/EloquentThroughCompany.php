<?php

namespace Sikasir\V1\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class EloquentThroughCompany implements Interfaces\QueryCompanyInterface
{
    /**
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model;
    
    /**
     *
     * @var integer
     */
    private $companyId;
    
    private $throughId;
    
    private $throughTableName;


    /**
     * 
     * @param Model $model
     * @param integer $companyId
     * @param integer $throughId
     * @param string $throughTableName
     */
    public function __construct(Model $model, $companyId, $throughTableName, $throughId = null) 
    {
        $this->model = $model;
        $this->companyId = $companyId;
        $this->throughId = $throughId;
        $this->throughTableName = $throughTableName;
    }
    
    public function forCompany()
    {
    	$modelForeignId = $this->model->getTable() . '.' . str_singular($this->throughTableName) . '_id';
    	
    	$constraint = $this->throughTableName . '.id' . ' = ' . $modelForeignId;
    	
        return $this->model
                    ->whereExists(
                        function ($query) use($modelForeignId, $constraint){

                            $query->selectRaw(1)
                                  ->from($this->throughTableName)
                                  ->where('company_id', '=', $this->companyId)
                                  ->whereRaw($constraint);
                            
                            if (! is_null($this->throughId)) {
                                $query->where('id', '=', $this->throughId);
                            }
                    });
    }

    public function dataForCompany(array $data) 
    {
    	
    	$tes = \DB::table($this->throughTableName)
		    		->whereCompanyId($this->companyId)
		    		->whereId($this->throughId)
		    		->get();
    	
    	if(empty($tes))
    	{
    		throw  new \Exception('thorugh data not found');
    	}
		    		
    	$foreignId = str_singular($this->throughTableName) . '_id';
    	
    	$data[$foreignId] = $this->throughId;
    	
    	return $this->model->fill($data);
        
    }

}
