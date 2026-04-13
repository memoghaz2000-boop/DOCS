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
        Schema::create('excipients', function (Blueprint $table) {
            $table->id();
            $table->string('excipient_name');
            $table->string('category')->nullable();
            $table->decimal('mw', 10, 4)->nullable();
            $table->decimal('acid_equivalents', 8, 4)->nullable();
            $table->decimal('base_equivalents', 8, 4)->nullable();
            $table->string('pKa_or_buffer_role')->nullable();
            $table->decimal('typical_lod_pct', 5, 2)->nullable();
            $table->string('hygroscopicity_level')->nullable();
            $table->decimal('cost_per_mg', 15, 6)->nullable();
            $table->text('compatibility_flags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excipients');
    }
};
