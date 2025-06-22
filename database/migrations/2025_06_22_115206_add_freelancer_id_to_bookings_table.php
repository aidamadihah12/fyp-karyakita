<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->unsignedBigInteger('freelancer_id')->nullable()->after('user_id');

        // If users table is used for freelancers:
        $table->foreign('freelancer_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['freelancer_id']);
        $table->dropColumn('freelancer_id');
    });
}

};
