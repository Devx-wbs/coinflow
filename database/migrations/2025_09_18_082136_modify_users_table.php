<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'role' column if not exists
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('merchant')->after('password');
            }

            // Modify 'email' to nullable only (no unique)
            $table->string('email')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop 'role' column
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            // Revert 'email' to not nullable (keep unique)
            $table->string('email')->nullable(false)->change();
        });
    }
};


