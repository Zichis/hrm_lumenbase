<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date','clock_in','clock_out'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
