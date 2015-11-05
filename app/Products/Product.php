<?php

namespace Sikasir\Products;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'barcode', 'show'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    public function outlets()
    {
        return $this->belongsToMany(\Sikasir\Outlets\Outlet::class, 'outlet_product')->withTimestamps();
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }
    
    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id');
    }
    
}
