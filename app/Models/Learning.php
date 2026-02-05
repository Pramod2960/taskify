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
        'assigned_to',
        'task_code'
    ];

    public function project()
    {
        return $this->belongsTo(ClientProject::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function files()
    {
        return $this->hasMany(\App\Models\File::class, 'learning_id');
    }

    protected static function booted()
    {
        static::creating(function ($learning) {
            $lastTask = self::whereNotNull('task_code')
                ->orderByDesc('id')
                ->first();

            $nextNumber = 1;

            if ($lastTask && preg_match('/T-(\d+)/', $lastTask->task_code, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            }

            $learning->task_code = 'T-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }
}
