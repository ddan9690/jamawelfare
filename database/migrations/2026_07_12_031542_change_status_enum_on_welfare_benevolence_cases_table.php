<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing records from 'completed' to 'closed'
        DB::table('welfare_benevolence_cases')
            ->where('status', 'completed')
            ->update(['status' => 'closed']);

        // Change the ENUM values
        DB::statement("
            ALTER TABLE welfare_benevolence_cases
            MODIFY COLUMN status ENUM('active', 'closed', 'suspended')
            NOT NULL DEFAULT 'active'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert existing records from 'closed' back to 'completed'
        DB::table('welfare_benevolence_cases')
            ->where('status', 'closed')
            ->update(['status' => 'completed']);

        // Restore the original ENUM values
        DB::statement("
            ALTER TABLE welfare_benevolence_cases
            MODIFY COLUMN status ENUM('active', 'completed', 'suspended')
            NOT NULL DEFAULT 'active'
        ");
    }
};