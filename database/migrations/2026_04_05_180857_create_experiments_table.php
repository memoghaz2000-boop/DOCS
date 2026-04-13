<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('experiments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('formula_id')->nullable();
            $table->string('experiment_type')->nullable();
            $table->string('experiment_code')->nullable();
            $table->decimal('batch_size', 10, 3)->nullable();
            $table->string('equipment_used')->nullable();
            $table->string('process_route')->nullable();
            $table->text('objective')->nullable();
            $table->string('run_status')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('formula_id')->references('id')->on('formulas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiments');
    }
};
