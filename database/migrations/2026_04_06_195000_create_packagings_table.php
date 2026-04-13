<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packagings', function (Blueprint $table) {
            $table->id();
            $table->string('material_type'); // e.g. Alu-Alu Blister, Tube, Desiccant Cap
            $table->decimal('wvtr_value', 8, 4)->nullable(); // Water Vapor Transmission Rate
            $table->string('thickness')->nullable();
            $table->string('supplier')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packagings');
    }
};
