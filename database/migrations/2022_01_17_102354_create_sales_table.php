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

            $table->bigInteger('instrutor_id')->unsigned();

            $table->string('transaction');
            $table->string('email_student');
            $table->string('payment_mode');
            $table->string('bank', 50)->nullable();
            $table->string('account', 225)->nullable();
            $table->boolean('blocked')->default(false);
            $table->enum('status', ['C', 'A', 'E', 'P']);
            $table->enum('sales_channel', ['VP', 'VA', 'VF']);
            $table->double('Price', 10, 2);
            $table->double('discountedPrice', 10, 2);
            $table->date('date_created');
            $table->timestamp('date_expired');
            $table->string('product_type')->nullable();
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
