<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Company;

class Tax extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'amount',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function company()
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
