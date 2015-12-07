<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\User\Owner;

interface BelongsToOwner
{

    /**
    * save the current model to owner
    *
    * @var array $date
    * @var Sikasir\V1\User\Owner
    *
    * @return void
    */
    public function saveForOwner(array $data, Owner $owner);

}
