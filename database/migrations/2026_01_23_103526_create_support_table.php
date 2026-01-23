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
       Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('subject');
            $table->text('description');
            $table->unsignedTinyInteger('status')->default(0);   // inactive
            $table->unsignedTinyInteger('priority')->default(1); // medium
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedTinyInteger('category_id');
            $table->string('attachments')->nullable();
            $table->timestamps();
            $table->timestamp('closed_at')->nullable();

            // Optional: foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
