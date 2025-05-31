<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasColumn('bookings', 'total_amount')) {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_amount', 8, 2)->nullable();
        });
    }
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('total_amount');
    });
}

};

