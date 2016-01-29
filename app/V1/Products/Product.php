<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Stocks\StockDetail;

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
    
    public function scopeisVariant($query)
    {
        return $query->whereNotNull('product_id');
    }
    
    public function scopeisNotVariant($query)
    {
        return $query->whereNull('product_id');
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function variants()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}
