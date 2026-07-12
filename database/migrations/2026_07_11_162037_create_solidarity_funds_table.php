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
        Schema::create('solidarity_funds', function (Blueprint $table) {
            $table->id();
            
            // Link to the specific member of a welfare
            $table->foreignId('welfare_member_id')->constrained('welfare_members')->onDelete('cascade');
            
            // The transaction details
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['deposit', 'deduction']); 
            
            // Payment method details
            $table->enum('payment_method', ['cash', 'mpesa', 'bank'])->nullable(); 
            $table->date('transaction_date'); 
            
            // Optional link to a specific case for deductions
            $table->foreignId('welfare_benevolence_case_id')->nullable()->constrained('welfare_benevolence_cases');
            
            // Audit fields
            $table->string('description')->nullable();
            $table->string('reference_number')->nullable(); // M-Pesa Transaction Code
            $table->foreignId('created_by')->nullable()->constrained('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solidarity_funds');
    }
};