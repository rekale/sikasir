<?php

namespace Sikasir\V1\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\Out;


class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Authorizable, HasRolesAndAbilities;

    /**
     * The database table used by the model.
    *
     * @var string
     */
    protected $table = 'users';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function userable()
    {
        return $this->morphTo();
    }
    
      
    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }
    
    public function stockOuts()
    {
        return $this->hasMany(Out::class);
    }

    /**
     * get current user's owner id
     * 
     * @return Sikasir\V1\User\Owner
     */
    public function getOwnerId()
    {
        if($this->userable instanceof Admin) {
            throw new \Exception("you're admin, you're don't have owner");
        }
        
        if ($this->userable instanceof Owner) {
            return $this->userable->id;
        }
        else {
            return $this->userable->owner_id;
        }
    }
    
}
