<?php

namespace App\Livewire\FormBuilder\GeneratedData;

use App\Models\FormBuilder;

class ControllerBuilder
{
    public function build($fields)
    {
        $rules = "";

        foreach ($fields as $field) {

            $ruleParts = [];

            //------------------------------------------------------
            // 1. REQUIRED / OPTIONAL
            //------------------------------------------------------
            if ($field->mandatory == 1) {

                if ($field->visibility_type === "conditional") {
                    $ruleParts[] = "nullable";
                    $ruleParts[] = "required_if:{$field->visibility_field},{$field->visibility_value}";
                } else {
                    $ruleParts[] = "required";
                }
            } else {
                $ruleParts[] = "nullable";
            }

            //------------------------------------------------------
            // 2. DATA TYPE RULES
            //------------------------------------------------------
            if ($field->data_type === "email") {
                $ruleParts[] = "email";
            }

            if (in_array($field->data_type, ["text", "textarea"]) && !empty($field->max_length)) {
                $ruleParts[] = "max:{$field->max_length}";
            }

            if ($field->data_type === "number") {
                $ruleParts[] = "numeric";
            }

            //------------------------------------------------------
            // Build final PHP rule string
            //------------------------------------------------------
            $ruleString = "'" . implode("','", $ruleParts) . "'";
            $rules .= "        '{$field->field_id}' => [{$ruleString}],\n";
        }

        //------------------------------------------------------
        // Final output: Controller code
        //------------------------------------------------------
        return "$rules";
    }
}
