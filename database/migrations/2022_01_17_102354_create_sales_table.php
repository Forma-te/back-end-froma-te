<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('producer_id')->unsigned();
            $table->foreign('producer_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('transaction')->nullable();
            $table->string('email_member')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('bank', 50)->nullable();
            $table->string('account', 225)->nullable();
            $table->string('product_type')->nullable();
            $table->enum('status', ['C', 'A', 'E', 'P']);
            $table->enum('sales_channel', ['VP', 'VA', 'VF']);
            $table->integer('discount')->default('0');
            $table->double('sale_price', 10, 2);
            $table->date('date_created')->nullable();
            $table->timestamp('date_expired')->nullable();
            $table->boolean('blocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
