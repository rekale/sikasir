<?php

namespace Sikasir\V1\Orders;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Products\Variant;

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
        'nego',
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
    
    public function variants()
    {
        return $this->belongsToMany(Variant::class)
                ->withPivot(['total', 'nego'])
                ->withTimestamps();
    }
    
    
    public function voidBy()
    {
        return $this->belongsTo(User::class, 'void_user_id');
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
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
