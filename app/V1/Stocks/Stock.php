<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Stocks\StockDetail;

class Stock extends Model
{
    protected $fillable = [
      'outlet_id',
      'product_id',
    ];
    
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'stock_details')
                ->withTimestamps()
                ->withPivot(['total']);
    }
    
    public function details()
    {
        return $this->hasMany(StockDetail::class);
    }
    
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    
    
}
