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
        Schema::create('licenses', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('plan_id');
        $table->unsignedBigInteger('subscription_id')->nullable();
        $table->string('license_key')->unique();
        $table->string('store_url')->nullable();
        $table->integer('max_activations')->default(1);
        $table->integer('used_activations')->default(0);
        $table->enum('status', ['active', 'revoked', 'expired'])->default('active');
        $table->string('plan')->default('free');
        $table->date('expiration_date')->nullable();
        $table->timestamps();
        
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license');
    }
};
