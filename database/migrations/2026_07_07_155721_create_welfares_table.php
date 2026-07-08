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
        Schema::create('welfares', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('abbreviation', 50);

            $table->foreignId('county_id')
                ->constrained('counties')
                ->restrictOnDelete();

            $table->enum('status', [
                'active',
                'suspended',
            ])->default('active');

            $table->text('description')->nullable();
            $table->string('logo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welfares');
    }
};
