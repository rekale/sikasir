<?php

namespace Sikasir\V1\Repositories\Inventories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;
use Sikasir\V1\Repositories\Traits\EloquentOwnerThroughable;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class OutRepository extends EloquentRepository implements OwnerThroughableRepo
{
    use EloquentOwnerThroughable;
    
    public function __construct(Out $model) 
    {
        parent::__construct($model);
    }
    
    public function saveForOwnerThrough(array $data, $companyId, $throughId, $throughTableName) 
    {
        $throughTableExist = \DB::table($throughTableName)
                                ->where('id', $throughId)
                                ->where('company_id', $companyId)
                                ->exists();
        
        if($throughTableExist) {
            
            $foreignId = str_singular($throughTableName) . '_id';
            
            $data[$foreignId] = $throughId;
            
            $entry =  $this->model->create($data);
            
            foreach ($data['variants'] as $variant) {
                $entry->variants()->attach($variant['id'], ['total' => $variant['total']]);
            }
            
            return $entry;
        }
        
    }
    
    
}
