<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    protected $fillable = ['form_id', 'section_name', 'section_order'];

    public function fields()
    {
        return $this->hasMany(FormField::class, 'section_id');
    }
}
