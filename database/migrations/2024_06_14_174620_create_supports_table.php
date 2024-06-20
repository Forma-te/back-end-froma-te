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
        Schema::create('supports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable(false)->unsigned();
            $table->bigInteger('lesson_id')->nullable(false)->unsigned();
            $table->bigInteger('producer_id')->nullable(false)->unsigned();
            $table->enum('status', ['P', 'A', 'C'])->default('P');
            $table->text('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('producer_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['user_id']);
            $table->index(['lesson_id']);
            $table->index(['producer_id']);
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
