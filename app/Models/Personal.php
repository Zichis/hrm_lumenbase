<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
    ];
}
