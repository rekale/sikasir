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

    public function transform(User $user)
    {
        return [
            'id' => $this->encode($user->id),
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

}
