<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\User;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class UserTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    protected $availableIncludes = [
        'outlets',
    	'abilities',
    ];

    public function transform(User $user)
    {
        $data = [
            'id' => $this->encode($user->id),
            'name' => $user->name,
            'email' => $user->email,
            'gender' => $user->gender,
            'title' => $user->title,
            'address' => $user->address,
            'phone'=> $user->phone,
            'icon' => $user->icon,
        ];
        
        //if it reports
        if (isset($user->total)) {
            $data['transaction_total'] = $user->total;
            $data['amounts'] = $user->amounts;
        }
        
        return $data;
    }
    
    public function includeOutlets(User $user)
    {
        return $this->collection($user->outlets, new OutletTransformer);
    }
    
    public function includeAbilities(User $user)
    {
    	$abilities = $user->getAbilities();
    	
    	$tes = $abilities->filter(function ($ability) {
  
    		return $ability->name === 'edit-product' ||
    			   $ability->name === 'report-order'  ||
    			   $ability->name === 'read-report' ||
    			   $ability->name === 'billing' ||
    			   $ability->name === 'void-order'
    		;
    	});
    	
    	$result = [];
    	
    	foreach ($tes as $abl) {
    		
    		switch ($abl->name) {
    			case 'edit-product':
    				$result[] = 1;
    				break;
    			case 'report-order':
    				$result[] = 2;
    				break;
    			case 'read-report':
    				$result[] = 3;
    				break;
    			case 'billing':
    				$result[] = 4;
    				break;
    			case 'void-order':
    				$result[] = 5;
    				break;
    		}
    		
    	}
    	
    	return $this->collection($result, new AbilityTransformer);
    }

}
