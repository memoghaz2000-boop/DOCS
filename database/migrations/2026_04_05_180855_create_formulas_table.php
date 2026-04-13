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
        Schema::create('formulas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('formula_code');
            $table->string('formula_status')->nullable();
            $table->decimal('target_fill_weight_mg', 10, 3)->nullable();
            $table->decimal('actual_fill_weight_mg', 10, 3)->nullable();
            $table->decimal('predicted_eq_ratio', 8, 4)->nullable();
            $table->decimal('predicted_pH_raw', 5, 2)->nullable();
            $table->decimal('compliance_pH', 5, 2)->nullable();
            $table->decimal('predicted_co2_ml', 10, 3)->nullable();
            $table->decimal('predicted_cost_per_unit', 10, 4)->nullable();
            $table->string('approval_state')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulas');
    }
};
