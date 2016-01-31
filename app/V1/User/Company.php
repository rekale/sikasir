<?php

namespace Sikasir\V1\User;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Suppliers\Supplier;
use Sikasir\V1\Transactions\Payment;
use Sikasir\V1\Outlets\Customer;

class Company extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password', 
        'phone', 
        'address', 
        'icon', 
        'active',
    ];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    /**
     * owner has many outlets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outlets()
    {
       return $this->hasMany(Outlet::class); 
    }
    
    /**
     * owner has many taxes
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxes()
    {
       return $this->hasMany(Tax::class); 
    }
    
    /**
     * owner has many discounts
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts()
    {
       return $this->hasMany(Discount::class); 
    }
    
    /**
     * owner has many payments
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
       return $this->hasMany(Payment::class); 
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyTrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, Category::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyTrough
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Outlet::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suppliers()
    {
       return $this->hasMany(Supplier::class); 
    }
    
    /**
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function customers()
    {
       return $this->hasMany(Customer::class); 
    }
}
