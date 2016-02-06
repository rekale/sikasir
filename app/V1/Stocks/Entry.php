<?php

namespace Sikasir\V1\Stocks;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\User\User;
use Sikasir\V1\Products\Variant;

class Entry extends Model
{
    protected $fillable = [
        'user_id',
        'outlet_id',
        'note',
        'input_at',
    ];
    
    public function operator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function variants()
    {
        return $this->belongsToMany(Variant::class)->withPivot(['total']);
    }
}
