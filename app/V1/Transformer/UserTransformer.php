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
        return [
            'id' => $this->encode($user->id),
            'name' => $user->name,
            'email' => $user->email,
            'gender' => $user->gender,
            'title' => $user->title,
            'address' => $user->address,
            'phone'=> $user->phone,
            'icon' => $user->icon,
        ];
    }
    
    public function includeOutlets(User $user)
    {
        return $this->collection($user->outlets, new OutletTransformer);
    }

}
