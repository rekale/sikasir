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

class Owner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'owners';
    
    protected $with = ['user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'business_name', 'phone', 'address', 'icon', 'active',];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
    
    /**
     * owner has many outlets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outlets()
    {
       return $this->hasMany(Outlet::class, 'owner_id'); 
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
    public function employees()
    {
        return $this->hasMany(\Sikasir\V1\User\Employee::class);
    }
    
     /**
     * owner has one app
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function app()
    {
       return $this->hasOne(App::class, 'owner_id'); 
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'owner_id');
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
       return $this->hasOne(Supplier::class); 
    }
}
