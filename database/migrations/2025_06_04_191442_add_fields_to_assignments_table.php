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
    Schema::table('assignments', function (Blueprint $table) {
        if (!Schema::hasColumn('assignments', 'event_id')) {
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
        }
        if (!Schema::hasColumn('assignments', 'freelancer_id')) {
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
        }
        if (!Schema::hasColumn('assignments', 'status')) {
            $table->string('status')->default('pending');
        }
    });
}


public function down()
{
    Schema::table('assignments', function (Blueprint $table) {
        $table->dropColumn(['event_id', 'freelancer_id', 'status']);
    });
}

};
