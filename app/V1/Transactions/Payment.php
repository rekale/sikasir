<?php

namespace Sikasir\V1\Transactions;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'description',
    ];
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function owners()
    {
        $this->belongsTo(Owner::class);
    }
}
