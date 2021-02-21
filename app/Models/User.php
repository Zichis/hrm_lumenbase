<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    // Relationships
    public function personal()
    {
        return $this->hasOne('App\Models\Personal');
    }

    public function name()
    {
        if (is_null($this->personal)) {
            return null;
        }

        return $this->personal->first_name . ' ' . $this->personal->last_name;
    }

    /** Relationships **/
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function attendance()
    {
        return $this->belongsToMany(Attendance::class);
    }
    /** End of Relationships **/

    public function rolesNames()
    {
        $names = [];

        foreach ($this->roles as $role) {
            $names[] = $role->name;
        }

        return $names;
    }

    // JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
