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
        Schema::create('product_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->decimal('strength_mg', 10, 3)->nullable();
            $table->decimal('fill_weight_target_mg', 10, 3)->nullable();
            $table->decimal('target_effervescence_sec', 8, 2)->nullable();
            $table->decimal('target_pH', 5, 2)->nullable();
            $table->decimal('pH_low', 5, 2)->nullable();
            $table->decimal('pH_high', 5, 2)->nullable();
            $table->decimal('target_f2_min', 8, 2)->nullable();
            $table->decimal('max_moisture_pct', 5, 2)->nullable();
            $table->decimal('max_cu_rsd_pct', 5, 2)->nullable();
            $table->decimal('rh_limit_pct', 5, 2)->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_profiles');
    }
};
