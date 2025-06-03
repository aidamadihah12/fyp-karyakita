<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    public function up()
    {
Schema::create('venues', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->string('location');
    $table->string('package_type');
    $table->string('event_type');
    $table->date('available_date');
    $table->decimal('price', 8, 2);
    $table->string('sample_photo')->nullable();
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('venues');
    }
}

