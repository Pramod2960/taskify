<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    protected $fillable=[
        'title',
        'status',
        'category'
    ];
}
