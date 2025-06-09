<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('location')->nullable()->after('event_date');      // or after whichever column you want
        $table->string('location_url')->nullable()->after('location');
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['location', 'location_url']);
    });
}

};
