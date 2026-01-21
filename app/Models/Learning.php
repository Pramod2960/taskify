<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'status',
        'category',
        'assigned_to'
    ];

    public function project()
    {
        return $this->belongsTo(ClientProject::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
