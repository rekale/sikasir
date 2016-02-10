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
        'name', 
        'description', 
        'unit',
        'icon',
    ];
    
    public function scopeGetTotalAndAmounts($query)
    {
        $query->selectRaw(
                        'products.*, '
                        . 'sum(order_variant.total) as total, '
                        . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
                    )
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->groupBy('products.id');
    }
    
    
    public function scopeOrderByBestSeller($query)
    {
        $query->orderBy('total', 'desc')
            ->orderBy('amounts', 'desc');
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
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
        return $this->hasMany(Variant::class);
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
