<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventIdToBookingsTable extends Migration
{
public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        if (!Schema::hasColumn('bookings', 'event_id')) {
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
        }
    });
}

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
}
