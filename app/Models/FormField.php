<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'field_name',
        'field_id',
        'data_type',
        'tooltip',
        'mandatory',
        'max_length',
        'rows',
        'visibility_type',
        'visibility_field',
        'visibility_value',
        'sync_field',
        'field_order',
    ];
}
