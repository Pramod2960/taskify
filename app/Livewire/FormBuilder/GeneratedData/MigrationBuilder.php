<?php

namespace App\Livewire\FormBuilder\GeneratedData;

use App\Models\FormBuilder;

class MigrationBuilder
{
    public function build($fields, $tableName = 'webforms')
    {
        $migration = "Schema::table('{$tableName}', function (\\Illuminate\\Database\\Schema\\Blueprint \$table) {\n";

        foreach ($fields as $field) {

            // Determine column type
            $type = match($field->data_type) {
                'text' => 'string',
                'textarea' => 'text',
                'number' => 'integer',
                'email' => 'string',
                'date' => 'date',
                'select', 'checkbox' => 'string',
                default => 'string',
            };

            // Default value for some fields
            $default = '';
            if ($field->data_type === 'textarea') {
                $default = '->nullable()';
            } elseif (in_array($field->field_id, ['mandatory'])) {
                $default = '->default(0)';
            } elseif (in_array($field->field_id, ['rows'])) {
                $default = "->nullable()->default('4')";
            } elseif (in_array($field->field_id, ['visibility_type'])) {
                $default = "->nullable()->default('always')";
            } else {
                $default = $type === 'string' ? '' : '->nullable()';
            }

            $migration .= "    if (!Schema::hasColumn('{$tableName}', '{$field->field_id}')) {\n";
            $migration .= "        \$table->{$type}('{$field->field_id}'){$default};\n";
            $migration .= "    }\n";
        }

        // Add timestamps if not exists
        $migration .= "    if (!Schema::hasColumn('{$tableName}', 'created_at')) {\n";
        $migration .= "        \$table->timestamps();\n";
        $migration .= "    }\n";

        $migration .= "});\n";

        return $migration;
    }
}
