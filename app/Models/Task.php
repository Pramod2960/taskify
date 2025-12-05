<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{

    protected $fillable = [
        'title',
        'body',
        'requirment',
        'project_id',
        'completion_date',
        'start_date',
        'assigner_id',
        'code_commited',
        'qa_status',
        'status'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(Assigner::class, 'assigner_id');
    }
}
