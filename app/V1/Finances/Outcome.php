<?php

namespace Sikasir\V1\Finances;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
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
        return $this->belongsTo(\Sikasir\V1\Outlets\Outlet::class, 'outlet_id');
    }
}
