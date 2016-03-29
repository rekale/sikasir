<?php


namespace Sikasir\V1\Factories;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;
use Sikasir\V1\Factories\Factory;

class EloquentFactory extends Factory
{
    protected $data;
    
    /**
     * 
     * @param array $data
     * 
     * @return Model
     */
    public function create(array $data)
    {
        $savedData = $this->query->dataForCompany($data);
            
        $savedData->save();
        
        return $savedData;
    }
    
    
}
