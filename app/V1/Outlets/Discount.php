<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Orders\Order;

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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
