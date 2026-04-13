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
        Schema::create('stability_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('formula_id')->nullable();
            $table->string('condition')->nullable();
            $table->string('timepoint')->nullable();
            $table->text('results')->nullable();
            $table->string('trend_flags')->nullable();
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
        Schema::dropIfExists('stability_records');
    }
};
