<?php

namespace Sikasir\Outlets;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'outlets';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'province', 'city', 'pos_code', 'phone1', 'phone2', 'icon'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    
    
    /**
     * outlet belongs to one owner
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(\Sikasir\User\Owner::class, 'owner_id');
    }
    
    /**
     * outlet have many employees
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->BelongsToMany(\Sikasir\User\Employee::class);
    }
    
    public function incomes()
    {
        return $this->hasMany(\Sikasir\Finances\Income::class, 'outlet_id');
    }
    
    public function outcomes()
    {
        return $this->hasMany(\Sikasir\Finances\Outcome::class, 'outlet_id');
    }
    
    public function customers()
    {
        return $this->hasMany(Customer::class, 'outlet_id');
    }
    
    public function products()
    {
        return $this->belongsToMany(\Sikasir\Products\Product::class, 'outlet_product');
    }

    
}
