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
    
    protected $with = ['businessfield', 'tax'];
    
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
    protected $hidden = ['created_at', 'updated_at', 'pivot'];


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
        return $this->hasMany(Order::class)
                    ->selectRaw(
                        "orders.*, " .
                       "sum( (variants.price - order_variant.nego) * order_variant.total ) as revenue, " .
                       "sum( ( (variants.price - order_variant.nego) * order_variant.total ) " //revenue
                           . " - " //dikurang
                           . "(variants.price_init * order_variant.total) ) " //modal awal
                           . "as profit " //jadi profit
                   )
                   ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
                   ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
                   ->where('void', '=', false)
                   ->groupBy('orders.id')
                   ->orderBy('revenue', 'desc')
                   ->orderBy('profit', 'desc');
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
