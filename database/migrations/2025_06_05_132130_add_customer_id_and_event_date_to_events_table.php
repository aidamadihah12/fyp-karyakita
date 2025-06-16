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
            if (!Schema::hasColumn('events', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable();
            }

            if (!Schema::hasColumn('events', 'event_date')) {
                $table->date('event_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'customer_id')) {
                $table->dropColumn('customer_id');
            }

            if (Schema::hasColumn('events', 'event_date')) {
                $table->dropColumn('event_date');
            }
        });
    }
};
