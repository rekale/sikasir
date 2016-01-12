<?php

namespace Sikasir\V1\Orders;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\User\User;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Outlets\Discount;

class Order extends Model
{

    protected $fillable = [
        'customer_id',
        'outlet_id',
        'user_id',
        'payment_id',
        'discount_id',
        'tax_id',
        'note',
        'total',
        'void',
        'void_user_id',
        'void_note',
        'paid',
    ];
    
    /**
     * 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(StockDetail::class, 'order_stockdetail')
                    ->withPivot(['total']);
    }
    
    
    public function voidBy()
    {
        return $this->belongsTo(User::class, 'void_user_id');
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
     
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    
}
