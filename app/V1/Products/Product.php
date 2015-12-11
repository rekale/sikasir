<?php

namespace Sikasir\V1\Products;

use Illuminate\Database\Eloquent\Model;

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
        'name', 
        'description', 
        'barcode', 
        'unit',
    ];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    public function outlets()
    {
        return $this->belongsToMany(\Sikasir\V1\Outlets\Outlet::class, 'outlet_product')->withTimestamps();
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    
}
