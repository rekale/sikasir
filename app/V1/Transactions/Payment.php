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
    
    
    public function scopeReport($query, $dateRange, $outletId = null)
    {
       $query->selectRaw(
            'payments.*, '
            . 'count(orders.id) as transaction_total, '
            . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
        )
        ->join('orders', 'payments.id', '=', 'orders.payment_id')
        ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
        ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
        ->whereBetween('order_variant.created_at', $dateRange)
        ->groupBy('payments.id');
       
       if(! is_null($outletId)) {
           $query->where('orders.outlet_id', '=', $outletId);
       }
    }
    
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
