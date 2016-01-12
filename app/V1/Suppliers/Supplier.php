<?php

namespace Sikasir\V1\Suppliers;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\Owner;

class Supplier extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'email',
        'phone',
        'address',
    ];
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
