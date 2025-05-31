<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    if (!Schema::hasColumn('events', 'image')) {
        Schema::table('events', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }
}
public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}

};
