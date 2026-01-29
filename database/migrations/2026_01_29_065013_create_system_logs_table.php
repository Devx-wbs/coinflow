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
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();

            $table->string('level')->default('error');


            $table->text('message');

            $table->longText('trace')->nullable();

            $table->string('file')->nullable();
            $table->integer('line')->nullable();

            $table->string('url')->nullable();

            $table->string('method')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('ip')->nullable();

            $table->boolean('is_resolved')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
