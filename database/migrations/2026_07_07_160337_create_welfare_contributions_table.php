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
        Schema::create('welfare_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('welfare_benevolence_case_id')->constrained('welfare_benevolence_cases')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('welfare_members')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_type', ['cash', 'mpesa']);
            $table->date('payment_date');
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();

            $table->unique(
                ['welfare_benevolence_case_id', 'member_id'],
                'wc_case_member_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welfare_contributions');
    }
};