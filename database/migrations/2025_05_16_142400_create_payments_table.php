<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->timestamp('payment_date')->useCurrent();
            $table->string('payment_method', 50);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['Successful', 'Failed'])->default('Successful');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

