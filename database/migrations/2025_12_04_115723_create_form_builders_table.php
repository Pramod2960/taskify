<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_builders', function (Blueprint $table) {
            if (!Schema::hasColumn('form_builders', 'section_name')) {
                $table->string('section_name');
            }
            if (!Schema::hasColumn('form_builders', 'field_name')) {
                $table->string('field_name');
            }
            if (!Schema::hasColumn('form_builders', 'field_id')) {
                $table->string('field_id');
            }
            if (!Schema::hasColumn('form_builders', 'data_type')) {
                $table->string('data_type');
            }
            if (!Schema::hasColumn('form_builders', 'mandatory')) {
                $table->boolean('mandatory')->default(0);
            }
            if (!Schema::hasColumn('form_builders', 'tooltip')) {
                $table->text('tooltip')->nullable();
            }
            if (!Schema::hasColumn('form_builders', 'max_length')) {
                $table->string('max_length')->nullable();
            }
            if (!Schema::hasColumn('form_builders', 'rows')) {
                $table->string('rows')->nullable()->default('4');
            }
            if (!Schema::hasColumn('form_builders', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_builders');
    }
};
