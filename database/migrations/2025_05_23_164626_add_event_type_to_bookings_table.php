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
        Schema::table('events', function (Blueprint $table) {
            // Check if the 'date' column doesn't already exist before adding it
            if (!Schema::hasColumn('events', 'date')) {
                $table->date('date')->nullable();  // Add the 'date' column
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Drop the 'date' column
            $table->dropColumn('date');
        });
    }
};
