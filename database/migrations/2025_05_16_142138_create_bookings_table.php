<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('event_type');
            $table->foreignId('assigned_staff')->constrained()->onDelete('cascade');
            $table->timestamps(); // This will create both created_at and updated_at automatically
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->decimal('total_amount', 8, 2);
            $table->date('event_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
