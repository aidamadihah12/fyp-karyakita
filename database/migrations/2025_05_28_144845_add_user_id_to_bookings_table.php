<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToBookingsTable extends Migration
{
public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable();  // Add user_id field
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  // Foreign key to users table
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}

}
