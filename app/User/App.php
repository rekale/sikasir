<?php

namespace Sikasir\User;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'apps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'created_at', 'updated_at'];
    
    /**
     * an app belong to one owner
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'member_id');
    }
}
