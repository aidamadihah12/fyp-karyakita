<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToBookingsTable extends Migration
{
public function up()
{
    if (!Schema::hasColumn('bookings', 'user_id')) {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}

}
