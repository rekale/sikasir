<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Owner;

class Tax extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'amount',
    ];
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function owners()
    {
        $this->belongsTo(Owner::class);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function outlet()
    {
        $this->hasMany(Outlet::class);
    }
}
