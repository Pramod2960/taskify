<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'field_name',   // label
        'field_id',     // internal id
        'data_type',
        'mandatory',
        'tooltip'
    ];
}
