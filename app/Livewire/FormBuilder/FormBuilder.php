<?php

namespace App\Livewire\FormBuilder;

use App\Livewire\FormBuilder\GeneratedData\ControllerBuilder;
use App\Livewire\FormBuilder\GeneratedData\HtmlBuilder;
use App\Livewire\FormBuilder\GeneratedData\JsBuilder;
use App\Livewire\FormBuilder\GeneratedData\MigrationBuilder;
use App\Models\Form;
use App\Models\FormBuilder as ModelsFormBuilder;
use App\Models\FormField;
use App\Models\FormSection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Form Builder')]
#[Layout('layouts.app')]
class FormBuilder extends Component
{
    //form
    public $form_id;
    public $form_name;

    public $section_id;
    public $section_name;

    public $field_name, $field_id, $data_type, $mandatory, $tooltip, $max_length = 255, $rows = 4, $sync_field;

    public $visibility_type = 'always', $visibility_field, $visibility_value;

    public $generatedHtml = '', $generatedJS, $generatedController, $generatedMigration;

    public function createForm()
    {
        // $this->validate([
        //     'form_name' => 'required',
        // ]);

        // $form = Form::create(['form_name' => $this->form_name]);
        // $this->form_id = $form->id;

        // session()->flash('message', 'Form created!');
    }

    // public function addSection()
    // {
    //     $this->validate([
    //         'section_name' => 'required',
    //     ]);

    //     $section = FormSection::create([
    //         'form_id' => $this->form_id,
    //         'section_name' => $this->section_name,
    //         'section_order' => FormSection::where('form_id', $this->form_id)->count() + 1,
    //     ]);

    //     $this->section_id = $section->id;
    //     $this->section_name = '';
    // }

    public function addField()
    {
        try {
            $this->validate([
                // 'section_name' => 'required',
                'field_name' => 'required',
                'field_id'   => 'required|alpha_dash',
                'data_type'  => 'required',
                'mandatory'  => 'required',
                'visibility_type' => 'required',
            ]);

            ModelsFormBuilder::create([
                'section_name' => $this->section_name,
                'field_name' => $this->field_name,
                'field_id'   => $this->field_id,
                'data_type'  => $this->data_type,
                'mandatory'  => $this->mandatory,
                'tooltip'    => $this->tooltip,
                'max_length' => $this->max_length,
                'rows'       => $this->rows,
                'visibility_type' => $this->visibility_type,
                'visibility_field' => $this->visibility_field,
                'visibility_value' => $this->visibility_value,
                'sync_field' => $this->sync_field,
                'form_name' => ' sd',
                // 'field_order' => FormField::where('section_id', $this->section_id)->count() + 1,
            ]);

            $this->resetFieldInputs();
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    private function resetFieldInputs()
    {
        $this->field_name = $this->field_id = $this->data_type = '';
        $this->tooltip = $this->sync_field = '';
        $this->mandatory = '';
        $this->visibility_type = 'always';
        $this->visibility_field = '';
        $this->visibility_value = '';
        $this->max_length = 255;
        $this->rows = 4;
    }

    public function copy($data)
    {
        $this->dispatchBrowserEvent('copy', ['text' => $data]);
    }

    public function generateHtml(HtmlBuilder $builder)
    {
        $fields = ModelsFormBuilder::get();
        $this->generatedHtml = $builder->build($fields);
    }
    public function generateJS(JsBuilder $builder)
    {
        $fields = ModelsFormBuilder::all();
        $this->generatedJS = $builder->build($fields);
    }
    public function generateController(ControllerBuilder $builder)
    {
        $fields = ModelsFormBuilder::all();
        $this->generatedController = $builder->build($fields);
    }
    public function generateMigration(MigrationBuilder $builder)
    {
        $fields = ModelsFormBuilder::all();
        $this->generatedMigration = $builder->build($fields);
    }

    public function render()
    {
        $form = $this->form_id ? Form::with('sections.fields')->find($this->form_id) : null;

        return view('livewire.FormBuilder.form-builder', [
            'form' => $form,
        ]);
    }
}
