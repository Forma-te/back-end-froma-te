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
            $table->id();
            $table->bigInteger('producer_id')->unsigned();
            $table->foreign('producer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('facebook_pixel')->nullable();
            $table->string('tiktok_pixel')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('google_ads_id')->nullable();
            $table->string('linkedin_pixel')->nullable();
            $table->string('twitter_pixel')->nullable();
            $table->timestamps();
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
