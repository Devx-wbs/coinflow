<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenseActivationsTable extends Migration
{
    public function up()
    {
        Schema::create('license_activations', function (Blueprint $table) {
            $table->id();

            // Foreign key to licenses table
            $table->unsignedBigInteger('license_id');
            $table->string('store_url');
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('deactivated_at')->nullable();

            $table->timestamps();

            // Unique activation per store per license
            $table->unique(['license_id', 'store_url']);

            // Foreign key constraint
            $table->foreign('license_id')
                  ->references('id')
                  ->on('licenses')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('license_activations');
    }
}
