<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Company;

class Tax extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'amount',
    ];
    
    protected $hidden = [
        'id',
        'owner_id',
        'created_at',
        'updated_at',
    ];


    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function owners()
    {
        $this->belongsTo(Company::class);
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
