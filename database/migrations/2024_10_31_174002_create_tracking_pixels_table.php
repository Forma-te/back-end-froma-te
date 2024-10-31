<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracking_pixels', function (Blueprint $table) {
            $table->id(); // ID único
            $table->bigInteger('producer_id')->unsigned();
            $table->foreign('producer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('pixel_type'); // Tipo do pixel (ex: 'facebook', 'google', etc.)
            $table->string('pixel_value'); // Valor do pixel (código do pixel)
            $table->timestamps(); // Campos de data de criação e atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_pixels');
    }
};
