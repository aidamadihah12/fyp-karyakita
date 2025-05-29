<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneAndUserRoleToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'phone' column if it does not exist
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }

            // Add 'user_role' column if it does not exist, default to 'freelance'
            if (!Schema::hasColumn('users', 'user_role')) {
                $table->string('user_role')->default('freelance');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop 'phone' column if exists
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }

            // Drop 'user_role' column if exists
            if (Schema::hasColumn('users', 'user_role')) {
                $table->dropColumn('user_role');
            }
        });
    }
}
