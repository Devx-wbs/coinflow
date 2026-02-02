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
        Schema::table('license_activations', function (Blueprint $table) {

            // Add plugin_id column
            $table->unsignedBigInteger('plugin_id')
                ->nullable()
                ->after('license_id');

            // Foreign key constraint
            $table->foreign('plugin_id')
                ->references('id')
                ->on('plugin_versions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('license_activations', function (Blueprint $table) {

            // Drop foreign key first
            $table->dropForeign(['plugin_id']);

            // Drop column
            $table->dropColumn('plugin_id');
        });
    }
};
