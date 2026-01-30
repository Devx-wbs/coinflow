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
        Schema::table('supports', function (Blueprint $table) {

            // 1️⃣ Drop old foreign key constraint first
            $table->dropForeign(['user_id']);

            // 2️⃣ Make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // 3️⃣ Add email column (nullable)
            $table->string('email')->nullable()->after('user_id');

            // 4️⃣ Add foreign key again with nullOnDelete
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supports', function (Blueprint $table) {

            // Drop email column
            $table->dropColumn('email');

            // Drop foreign key again
            $table->dropForeign(['user_id']);

            // Make user_id required again
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            // Restore cascade delete
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
};
