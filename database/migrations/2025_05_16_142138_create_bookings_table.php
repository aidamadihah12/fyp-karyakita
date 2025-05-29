<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();  // Equivalent to 'id' in your image
        $table->bigInteger('user_id');
        $table->bigInteger('event_id');
        $table->string('event_type');
        $table->bigInteger('assigned_staff');
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
        $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
        $table->decimal('total_amount', 8, 2);
        $table->date('event_date');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
