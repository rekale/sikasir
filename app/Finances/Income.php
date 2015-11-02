<?php

namespace Sikasir\Finances;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['outlet_id', 'total', 'note'];
    
     /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    public function outlet()
    {
        return $this->belongsTo(\Sikasir\Outlets\Outlet::class, 'outlet_id');
    }
}
