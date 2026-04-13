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
        Schema::create('formula_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formula_id');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->string('material_type')->nullable(); // Excipient or Api
            $table->string('role_in_formula')->nullable();
            $table->decimal('amount_mg', 10, 4)->nullable();
            $table->decimal('moles', 10, 6)->nullable();
            $table->decimal('acid_eq_contribution', 10, 6)->nullable();
            $table->decimal('base_eq_contribution', 10, 6)->nullable();
            $table->decimal('cost_contribution', 15, 6)->nullable();
            $table->boolean('is_critical_component')->default(false);
            $table->timestamps();
            
            $table->foreign('formula_id')->references('id')->on('formulas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula_components');
    }
};
