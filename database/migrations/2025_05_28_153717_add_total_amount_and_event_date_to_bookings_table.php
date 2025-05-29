<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalAmountAndEventDateToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add columns only if they do not exist
            if (!Schema::hasColumn('bookings', 'total_amount')) {
                $table->decimal('total_amount', 8, 2)->nullable();  // Add the total_amount column
            }

            if (!Schema::hasColumn('bookings', 'event_date')) {
                $table->date('event_date')->nullable();  // Add the event_date column
            }
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'event_date']);
        });
    }
}
