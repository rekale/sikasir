<?php

namespace Sikasir\V1\Orders;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'total',
        'due_date',
        'paid_at',
    ];
}
