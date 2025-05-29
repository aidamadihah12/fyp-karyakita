<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    public function up()
    {
Schema::create('assignments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('booking_id');
    $table->unsignedBigInteger('freelancer_id');
    $table->string('status')->default('assigned');
    $table->timestamps();

    $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
    $table->foreign('freelancer_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
