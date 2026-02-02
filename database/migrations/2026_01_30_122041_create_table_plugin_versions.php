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
        Schema::create('plugin_versions', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('version', 50)->unique();
            $table->string('zip_path', 255);
            $table->date('released_at');

            $table->unsignedTinyInteger('state_id')
                ->default(1)
                ->comment('0=Inactive, 1=Active');
            $table->unsignedTinyInteger('category_id')
                ->default(1)
                ->comment('1=Standard, 2=Support Alert, 3=Security Alert');
            $table->unsignedTinyInteger('type_id')
                ->default(1)
                ->comment('0=Outdated,1=Latest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugin_versions');
    }
};
