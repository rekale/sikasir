<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    protected $fillable = [
        'outlet_id',
        'code',
        'name',
        'logo',
        'adddress',
        'info',
        'footer_note',
        'size',
    ];
    
    public function getSizeAttribute($value)
    {
        if ($value === 1) {
            return 'A4';
        }
        if ($value === 2) {
            return 'Receipt Paper Roll';
        }
    }
}
