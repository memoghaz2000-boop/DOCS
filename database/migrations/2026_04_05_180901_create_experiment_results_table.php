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
        Schema::create('experiment_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('experiment_id');
            $table->decimal('effervescence_sec', 8, 2)->nullable();
            $table->decimal('f2_worst', 8, 2)->nullable();
            $table->decimal('moisture_pct', 5, 2)->nullable();
            $table->decimal('cu_rsd_pct', 5, 2)->nullable();
            $table->decimal('measured_pH', 5, 2)->nullable();
            $table->integer('taste_score')->nullable();
            $table->string('appearance_result')->nullable();
            $table->string('pass_fail')->nullable();
            $table->timestamps();
            
            $table->foreign('experiment_id')->references('id')->on('experiments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiment_results');
    }
};
