<?php

// database/migrations/xxxx_xx_xx_create_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Event name
            $table->date('event_date');    // Event date
            $table->integer('price');  // Event price
            $table->integer('available_slots');  // Available slots for the event
            $table->string('image')->nullable();  // Image URL, nullable
            $table->timestamps();  // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}

