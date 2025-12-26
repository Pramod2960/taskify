<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientProject extends Model
{

    protected $fillable = [
        'name',
        'description',
    ];

    public function learnings()
    {
        return $this->hasMany(Learning::class);
    }
}
