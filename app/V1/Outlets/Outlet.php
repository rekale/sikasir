<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Products\Product;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\Finances\Income;
use Sikasir\V1\Finances\Outcome;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Stocks\Stock;

class Outlet extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'outlets';

    protected $with = ['businessfield'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_field_id', 'code','name', 'address', 'province', 'city', 'pos_code',
        'phone1', 'phone2', 'icon'
    ];

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
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * outlet belongs to one owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function businessfield()
    {
        return $this->belongsTo(BusinessField::class, 'business_field_id');
    }

    /**
     * outlet have many employees
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->BelongsToMany(Employee::class);
    }
    
    /**
     * outlet have many cashier
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function cashiers()
    {
        return $this->hasMany(Cashier::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'outlet_id');
    }

    public function outcomes()
    {
        return $this->hasMany(Outcome::class, 'outlet_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'outlet_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'stocks');
    }
    
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }


}
