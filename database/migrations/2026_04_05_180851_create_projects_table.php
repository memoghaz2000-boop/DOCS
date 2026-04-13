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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code')->nullable();
            $table->string('project_name')->nullable();
            $table->unsignedBigInteger('api_id')->nullable(); // Foreign Key later
            $table->string('dosage_form')->nullable();
            $table->string('development_stage')->nullable();
            $table->string('reference_product')->nullable();
            $table->string('target_market')->nullable();
            $table->string('project_status')->nullable();
            $table->string('owner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
