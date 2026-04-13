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
        Schema::create('risk_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('failure_mode');
            $table->integer('severity')->nullable();
            $table->integer('occurrence')->nullable();
            $table->integer('detectability')->nullable();
            $table->integer('rpn')->nullable();
            $table->text('mitigation')->nullable();
            $table->string('gate_state')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_records');
    }
};
