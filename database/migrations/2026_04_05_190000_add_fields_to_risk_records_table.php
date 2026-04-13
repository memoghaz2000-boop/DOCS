<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risk_records', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_records', 'risk_owner')) {
                $table->string('risk_owner')->nullable();
            }
            if (!Schema::hasColumn('risk_records', 'review_date')) {
                $table->date('review_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('risk_records', function (Blueprint $table) {
            $table->dropColumn(['risk_owner', 'review_date']);
        });
    }
};
