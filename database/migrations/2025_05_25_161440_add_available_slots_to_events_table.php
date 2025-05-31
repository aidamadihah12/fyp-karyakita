<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    if (!Schema::hasColumn('events', 'available_slots')) {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('available_slots')->default(0);
        });
    }
}

    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('available_slots');
    });
}

};
