<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Add missing columns (if not already present)
            if (!Schema::hasColumn('users', 'image')) {
                $table->string('image')->nullable()->after('name');
            }

            if (!Schema::hasColumn('users', 'store_name')) {
                $table->string('store_name')->nullable()->after('country');
            }

            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->nullable()->after('role');
            }

            // Remove company_name completely
            if (Schema::hasColumn('users', 'company_name')) {
                $table->dropColumn('company_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Re-add company_name if rolled back
            $table->string('company_name')->nullable()->after('country');

            // Remove newly added columns
            $table->dropColumn(['image', 'store_name', 'status']);
        });
    }
};
