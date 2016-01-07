<?php

namespace Sikasir\V1\Orders;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\User\User;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Outlets\Outlet;

class Order extends Model
{
    protected $with = ['stocks'];


    protected $fillable = [
        'customer_id',
        'outlet_id',
        'user_id',
        'note',
        'total',
        'void',
        'void_user_id',
        'void_note',
    ];
    
    /**
     * 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stockdetails()
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
}
