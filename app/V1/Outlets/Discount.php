<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'amount',
    ];
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function company()
    {
        $this->belongsTo(Company::class);
    }
}
