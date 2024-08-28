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
        Schema::create('sale_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');

            $table->bigInteger('producer_id')->unsigned();
            $table->foreign('producer_id')->references('id')->on('users')->onDelete('cascade');

            $table->Integer('quantity')->nullable();
            $table->double('total', 10, 2);
            $table->date('date_start');
            $table->timestamp('date_the_end');
            $table->enum('status', ['Aprovado', 'Expirado']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_subscriptions');
    }
};
