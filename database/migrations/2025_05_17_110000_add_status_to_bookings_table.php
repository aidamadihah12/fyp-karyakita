<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBookingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('bookings', 'status')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            });
        }
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
