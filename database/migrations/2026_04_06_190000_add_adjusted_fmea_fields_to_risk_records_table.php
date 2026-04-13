<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risk_records', function (Blueprint $table) {
            $table->integer('severity_adj')->nullable();
            $table->integer('occurrence_adj')->nullable();
            $table->integer('detectability_adj')->nullable();
            $table->integer('rpn_adj')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('risk_records', function (Blueprint $table) {
            $table->dropColumn(['severity_adj', 'occurrence_adj', 'detectability_adj', 'rpn_adj']);
        });
    }
};
