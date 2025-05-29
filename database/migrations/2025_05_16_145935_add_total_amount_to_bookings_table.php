<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        // Add total_amount column (if it doesn't exist)
        $table->decimal('total_amount', 8, 2)->nullable();  // Example for decimal with 2 decimal places
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('total_amount');
    });
}

};

