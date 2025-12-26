<?php

namespace App\Livewire\FormBuilder\GeneratedData;

use App\Models\FormBuilder;

class JsBuilder
{
    public function build($fields)
    {
        $rules = "";
        $conditions = "";

        foreach ($fields as $field) {

            //--------------------------------------------------
            // 1. Build Validation RULES
            //--------------------------------------------------
            $rules .= "{$field->field_id}: {\n";

            // Mandatory
            if ($field->mandatory == 1) {
                if ($field->visibility_type === 'conditional') {
                    $rules .= "   required: function() {
                        return $(\"#{$field->visibility_field}\").val() == \"{$field->visibility_value}\";
                    },\n";
                } else {
                    $rules .= "   required: true,\n";
                }
            } else {
                if ($field->visibility_type === 'conditional') {
                    $rules .= "   required: function() {
                        return $(\"#{$field->visibility_field}\").val() == \"{$field->visibility_value}\";
                    },\n";
                } else {
                    $rules .= "   required: false,\n";
                }
            }

            // Max Length
            if (!empty($field->max_length)) {
                $rules .= "   maxlength: {$field->max_length},\n";
            }

            // Email Validation
            if ($field->data_type == "email") {
                $rules .= "   email: true,\n";
            }

            $rules .= "},\n\n";

            //--------------------------------------------------
            // 2. Build Conditional Logic
            //--------------------------------------------------
            if ($field->visibility_type === "conditional") {

                $conditions .= "
                    $(\"#{$field->visibility_field}\").on(\"change\", function() {
                        let val = $(this).val();

                        if (val === \"{$field->visibility_value}\") {
                            $(\".field-wrapper-{$field->field_id}\").removeClass(\"d-none\");
                            $(\"#{$field->field_id}\").attr(\"data-required\", \"true\");
                        } else {
                            $(\".field-wrapper-{$field->field_id}\").addClass(\"d-none\");
                            $(\"#{$field->field_id}\").val(\"\");
                            $(\"#{$field->field_id}\").attr(\"data-required\", \"false\");
                        }
                    });
                ";
            }
        }

        //--------------------------------------------------
        // Final Output
        //--------------------------------------------------

        return "
            form.validate({
                rules: {
                    $rules
                }
            });

            // Conditional Logic
            $conditions
        ";
    }
}
