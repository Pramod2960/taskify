<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientProject extends Model
{
    protected $table = 'client_projects';

    protected $fillable = [
        'name',
        'description',
    ];

    public function learnings()
    {
        return $this->hasMany(Learning::class, 'project_id');
    }

    public function newLearningsCount()
    {
        return $this->learnings()
            ->where('status', 'New')
            ->count();
    }


    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'project_user',
            'project_id',
            'user_id'
        );
    }
}
