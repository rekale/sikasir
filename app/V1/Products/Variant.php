<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Outlets\Outlet;

class Variant extends Model
{
    protected $table = 'variants';
    
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'code', 
        'price', 
        'track_stock',
        'stock',
        'alert',
        'alert_at',
        ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function outlets()
    {
        return $this->belongsToMany(Outlet::class, 'stocks')
                ->withTimestamps()
                ->withPivot('total');
    }
}
