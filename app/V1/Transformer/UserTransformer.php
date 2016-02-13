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

}
