<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventDateToBookingsTable extends Migration
{
public function up()
{
    if (!Schema::hasColumn('bookings', 'event_date')) {
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('event_date')->nullable();
        });
    }
}


    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('event_date');
        });
    }
}
