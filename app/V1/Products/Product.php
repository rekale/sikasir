<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Stocks\Opname;
use Sikasir\V1\Stocks\PurchaseOrder;

class Product extends Model
{
    protected $table = 'products';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'outlet_id',
        'product_id',
        'name', 
        'description', 
        'barcode', 
        'unit',
        'icon',
        'price_init',
        'price',
        'countable',
        'track_stock',
        'stock',
        'alert',
        'alert_at',
    ];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outlets()
    {
        return $this->belongsToMany(Outlet::class);
    }
    
    public function scopewhereIsVariant($query)
    {
        return $query->whereNotNull('product_id');
    }
    
    public function scopewhereIsNotVariant($query)
    {
        return $query->whereNull('product_id');
    }
    
    /**
     * check if current product is variant or not
     * 
     * @return boolean
     */
    public function isVariant()
    {
        return ! is_null($this->product_id);
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function variants()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
    
    public function entries()
    {
        return $this->belongsToMany(Entry::class)->withPivot('total');
    }
    
    public function outs()
    {
        return $this->belongsToMany(Out::class)->withPivot('total');
    }
    
    public function opnames()
    {
        return $this->belongsToMany(Opname::class)->withPivot('total');
    }
    
    public function purchases()
    {
        return $this->belongsToMany(PurchaseOrder::class)->withPivot('total');
    }
    
}
