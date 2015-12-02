<?php

namespace Sikasir\V1\Outlets;

use Illuminate\Database\Eloquent\Model;

class BusinessField extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
}
