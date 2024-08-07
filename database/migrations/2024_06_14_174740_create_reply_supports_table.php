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
        Schema::create('reply_support', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('producer_id')->nullable(false)->unsigned();
            $table->bigInteger('support_id')->nullable(false)->unsigned();
            $table->text('description');
            $table->timestamps();

            $table->foreign('producer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('support_id')->references('id')->on('supports')->onDelete('cascade');

            $table->index(['producer_id']);
            $table->index(['support_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reply_support');
    }
};
