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
    Schema::table('events', function (Blueprint $table) {
        $table->text('desc')->nullable(); // You can use nullable() if it's optional
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('desc');
    });
}

};
