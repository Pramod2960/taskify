<?php

namespace App\Livewire\FormBuilder;

use App\Models\FormBuilder as FormBuilderModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\FormBuilder\GenertedData\HtmlBuilder;

#[Title('Form Builder')]
#[Layout('layouts.app')]
class FormBuilder extends Component
{
    //form
    public $section_name;
    public $field_name, $field_id, $data_type, $mandatory, $tooltip, $max_length = 255, $rows = 4;

    public $generatedHtml = '';

    public function save()
    {
        $this->validate([
            'section_name' => 'required',
            'field_name'   => 'required',
            'field_id'     => 'required|alpha_dash',
            'data_type'    => 'required',
            'mandatory'    => 'required',
        ]);

        FormBuilderModel::create([
            'section_name' => $this->section_name,
            'field_name'   => $this->field_name,
            'field_id'     => $this->field_id,
            'data_type'    => $this->data_type,
            'tooltip'      => $this->tooltip,
            'mandatory'    => $this->mandatory,
            'max_length'   => $this->max_length,
            'rows'         => $this->rows,
        ]);

        $this->reset(['section_name', 'field_name', 'field_id', 'data_type', 'mandatory']);
        session()->flash('message', 'Field added successfully!');
    }

    public function generateHtml(HtmlBuilder $builder)
    {
        $fields = FormBuilderModel::orderBy('section_name')->get();
        $this->generatedHtml = $builder->build($fields);
    }

    public function render()
    {
        return view('livewire.FormBuilder.form-builder');
    }
}
