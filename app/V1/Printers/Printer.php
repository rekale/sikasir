<?php

namespace Sikasir\V1\Printers;

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
}
