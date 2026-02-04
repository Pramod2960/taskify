<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'learning_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function learning()
    {
        return $this->belongsTo(Learning::class);
    }
}
