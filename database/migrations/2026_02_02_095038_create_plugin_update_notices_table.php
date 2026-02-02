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
        Schema::create('plugin_update_notices', function (Blueprint $table) {

            $table->id();

            // Foreign Keys
            $table->foreignId('plugin_version_id')
                ->constrained('plugin_versions')
                ->onDelete('cascade');

            $table->foreignId('license_id')
                ->constrained('licenses')
                ->onDelete('cascade');

            $table->unsignedBigInteger('type_id')
                ->nullable()
                ->comment('Plugin type (Free, Pro, Beta etc)');

            // Store/User Info
            $table->string('email');
            $table->string('store_url');

            // Status Tracking
            $table->tinyInteger('status')
                ->default(0)
                ->comment('0=pending, 1=sent, 2=failed');

            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamps();

            // Prevent duplicate notice
            $table->unique(['plugin_version_id', 'license_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugin_update_notices');
    }
};
