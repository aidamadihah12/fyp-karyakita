<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->unsignedBigInteger('photographer_id')->nullable()->after('user_id');
        $table->foreign('photographer_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['photographer_id']);
        $table->dropColumn('photographer_id');
    });
}

};
