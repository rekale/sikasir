<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\Company;

class Category extends Model
{
    protected $table = 'categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'name',
        'description',
    ];
    
    public function scopeGetTotalAndAmounts($query, $dateRange, $outletId = null)
    {
        $query->selectRaw(
                        'categories.*, '
                        . 'sum(order_variant.total) as total, '
                        . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
                    )
                    ->join('products', 'categories.id', '=', 'products.category_id')
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereBetween('order_variant.created_at', $dateRange)
                    ->groupBy('categories.id');
        
        if(! is_null($outletId))
        {
            $query->where('products.outlet_id', '=', $outletId);
        }
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
