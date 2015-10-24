<?php

namespace Sikasir\Finances;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable = ['id', 'outlet_id', 'total', 'note'];
    
     /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['outlet_id',];
    
    public function outlet()
    {
        return $this->belongsTo(\Sikasir\Outlet::class, 'outlet_id');
    }
}
