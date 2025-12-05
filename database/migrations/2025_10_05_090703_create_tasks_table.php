<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('title');

            $table->longText('requirment');
            $table->longText('body');
            $table->integer('project_id');
            $table->string('assigner')->nullable();
            $table->string('status')->default('New');
            $table->date('start_date');
            $table->date('completion_date')->nullable();

            $table->tinyInteger('code_pushed')->default('0');
            $table->string('QA Status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
