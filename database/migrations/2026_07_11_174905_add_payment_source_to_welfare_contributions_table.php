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
        Schema::table('welfare_contributions', function (Blueprint $table) {
            $table->enum('payment_type', ['cash', 'mpesa', 'solidarity_fund'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('welfare_contributions', function (Blueprint $table) {
            //
        });
    }
};
