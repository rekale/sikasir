<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Products\Product;
use Sikasir\V1\User\Company;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Finances\Income;
use Sikasir\V1\Finances\Outcome;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Stocks\Opname;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\Outlets\Printer;
use Sikasir\V1\Products\Variant;

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
    protected $fillable = [
        'company_id',
        'business_field_id', 
        'tax_id',
        'code',
        'name', 
        'address', 
        'province', 
        'city', 
        'pos_code',
        'phone1', 
        'phone2', 
        'icon', 
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
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * outlet belongs to one owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function businessField()
    {
        return $this->belongsTo(BusinessField::class, 'business_field_id');
    }
    
    /**
     * outlet have one kind of tax
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * outlet have many employees
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->BelongsToMany(User::class);
    }
   
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomes()
    {
        return $this->hasMany(Income::class, 'outlet_id');
    }

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outcomes()
    {
        return $this->hasMany(Outcome::class, 'outlet_id');
    }

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    /**
     * get the best products from outlet
     * the best products determined by how many it sold
     * 
     * @param array $dateRange
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function bestProducts()
    {
        return $this->hasMany(Product::class)->selectRaw(
                            'products.outlet_id, products.id, products.name, '
                            . 'sum(order_variant.total) as total, '
                            . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
                        )
                        ->join('variants', 'variants.product_id', '=', 'products.id')
                        ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                        ->groupBy('products.id')
                        ->orderBy('total', 'desc')
                        ->orderBy('amounts', 'desc')
                        ->limit(5);
    }
    
    public function variants()
    {
        return $this->hasManyThrough(Variant::class, Product::class);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
    
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outs()
    {
        return $this->hasMany(Out::class);
    }
    
     /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opnames()
    {
        return $this->hasMany(Opname::class);
    }
    
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function printers()
    {
        return $this->hasMany(Printer::class);
    }
}
