<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('form_sections')->onDelete('cascade');

            $table->string('field_name');
            $table->string('field_id')->unique();
            $table->string('data_type');
            $table->string('tooltip')->nullable();

            $table->boolean('mandatory')->default(0);
            $table->integer('max_length')->default(255)->nullable();
            $table->integer('rows')->default(4)->nullable();

            $table->enum('visibility_type', ['always', 'conditional'])->default('always');
            $table->string('visibility_field')->nullable();
            $table->string('visibility_value')->nullable();

            $table->string('sync_field')->nullable();

            $table->integer('field_order')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_fields');
    }
};
