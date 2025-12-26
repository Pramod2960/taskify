<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['form_name'];

    public function sections()
    {
        return $this->hasMany(FormSection::class)->orderBy('section_order');
    }
}
