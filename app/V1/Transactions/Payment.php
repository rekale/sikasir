<?php

namespace Sikasir\V1\Transactions;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Orders\Order;

class Payment extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function company()
    {
        $this->belongsTo(Company::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
