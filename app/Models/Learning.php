<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'status',
        'category'
    ];

    public function project()
    {
        return $this->belongsTo(ClientProject::class);
    }
    
}
