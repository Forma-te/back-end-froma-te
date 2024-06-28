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
        Schema::create('sale_instructors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('producer_id')->unsigned();
            $table->bigInteger('plan_id')->unsigned();
            $table->string('transaction');
            $table->Integer('quantity')->nullable();
            $table->double('price', 10, 2);
            $table->double('total', 10, 2);
            $table->string('email');
            $table->enum('status', ['started', 'approved', 'expired']);
            $table->date('date');
            $table->timestamps();

            $table->foreign('producer_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->foreign('plan_id')
                    ->references('id')->on('plans')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_instructors');
    }
};
