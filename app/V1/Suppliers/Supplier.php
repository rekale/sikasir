<?php

namespace Sikasir\V1\Suppliers;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\Company;
use Sikasir\V1\Stocks\PurchaseOrder;

class Supplier extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
