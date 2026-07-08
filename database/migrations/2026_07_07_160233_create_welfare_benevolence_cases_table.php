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
        Schema::create('welfare_benevolence_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('welfare_id')->constrained()->cascadeOnDelete();
            $table->string('case_number');
            $table->foreignId('member_id')->constrained('welfare_members')->cascadeOnDelete();
            $table->foreignId('benevolence_category_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount_to_contribute', 12, 2);
            $table->date('deadline');
            $table->enum('status', ['active', 'completed', 'suspended'])->default('active');
            $table->foreignId('created_by')->constrained('users');
            $table->text('details')->nullable();
            $table->timestamps();

            $table->unique(['welfare_id', 'case_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welfare_benevolence_cases');
    }
};