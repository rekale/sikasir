<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Stocks\Stock;

class Variant extends Model
{
    protected $table = 'variants';
    
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'name', 
        'barcode', 
        'price_init',
        'price',
        'countable',
        'track_stock',
        'stock',
        'alert',
        'alert_at',
        'icon',
        ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function outlets()
    {
        return $this->belongsToMany(Outlet::class)
                ->withTimestamps()
                ->withPivot(['total', 'nego']);
    }
    
}
