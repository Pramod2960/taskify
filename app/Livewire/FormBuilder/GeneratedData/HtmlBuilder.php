<?php

namespace App\Livewire\FormBuilder\GeneratedData;

use Illuminate\Support\Collection;

class HtmlBuilder
{
    public function build(Collection $fields): string
    {
        $html = '';
        foreach ($fields->groupBy('section_name') as $section => $items) {
            $html .= '<div class="row">';

            foreach ($items as $field) {
                $method = "build" . ucfirst($field->data_type);
                
                if (method_exists($this, $method)) {
                    $html .= $this->$method($field);
                }
            }

            $html .= '</div>';
        }
        return $html;
    }

    private function buildText($field): string
    {
        $required = $field->mandatory ? 'required_field' : '';
        $tooltipHtml = $this->tooltip($field->tooltip);
        $errorSpan = "<span class='text-danger error-text {$field->field_id}_error'></span>";
        $hiddenClass = ($field->visibility_type === 'conditional') ? 'd-none' : '';

        return "
        div class='field-wrapper-{$field->field_id} {$hiddenClass}'>  
            <div class='col-sm-3 mb-3 field_pos'>
                <label class='form-label' for='{$field->field_id}'>
                    {$field->field_name} {$tooltipHtml}
                </label>
            </div>

            <div class='col-sm-9 mb-3 field_pos'>
                <input type='text' 
                    name='{$field->field_id}' 
                    id='{$field->field_id}' 
                    value='{{ old('{$field->field_id}') }}' 
                    class='form-control mb-3 {$required}'>
                    {$errorSpan}
            </div>
        </div>
        ";
    }

    private function buildTextArea($field): string
    {
        $required = $field->mandatory ? 'required_field' : '';
        $tooltipHtml = $this->tooltip($field->tooltip);
        $errorSpan = "<span class='text-danger error-text {$field->field_id}_error'></span>";

        return "
            <div class='col-sm-3 mb-3 field_pos'>
                <label class='form-label' for='{$field->field_id}'>
                    {$field->field_name} {$tooltipHtml}
                </label>
            </div>
            <div class='col-sm-9 mb-3 field_pos'>
                <input type='text' 
                    name='{$field->field_id}' 
                    id='{$field->field_id}' 
                    value='{{ old('{$field->field_id}') }}' 
                    class='form-control mb-3 {$required}'
                    maxlength='{$field->max_length}'
                    rows='{$field->rows}'
                    >
                    {$errorSpan}
            </div>
        ";
    }

    private function buildEmail($field): string
    {
        $required = $field->mandatory ? 'required_field' : '';

        return "
            <div class='form-group'>
                <label>{$field->field_name}</label>
                <input type='email' 
                    name='{$field->field_id}' 
                    id='{$field->field_id}' 
                    class='form-control {$required}'>
            </div>
        ";
    }

    private function buildNumber($field): string
    {
        $required = $field->mandatory ? 'required_field' : '';

        return "
            <div class='form-group'>
                <label>{$field->field_name}</label>
                <input type='number' 
                    name='{$field->field_id}' 
                    id='{$field->field_id}' 
                    class='form-control {$required}'>
            </div>
        ";
    }

    private function tooltip($text): string
    {
        if (empty($text)) {
            return '';
        }
        return "
            <span class='right-icon-exclamation-inline' data-toggle='tooltip' title='{$text}'>
                <i class='fas fa-info-circle tooltip-info-color'></i>
            </span>
        ";
    }
}
