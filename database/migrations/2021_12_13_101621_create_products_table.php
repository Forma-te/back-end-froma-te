<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 150)->default(null);
            $table->string('short_name', 150)->nullable();
            $table->string('url', 255)->unique();
            $table->text('description')->nullable();
            $table->text('spotlight')->nullable();
            $table->string('image', 225)->nullable();
            $table->string('file', 225)->nullable();
            $table->boolean('allow_download')->nullable();
            $table->string('product_type', 225)->nullable();
            $table->string('code', 255)->unique()->default(null);
            $table->time('total_hours')->default('0');
            $table->boolean('published');
            $table->boolean('free')->default(false);
            $table->double('price', 10, 2);
            $table->integer('discount')->nullable();
            $table->integer('acceptsMcxPayment')->nullable();
            $table->integer('acceptsRefPayment')->nullable();
            $table->integer('affiliationPercentage')->nullable();
            $table->double('price_plots', 10, 2)->nullable();
            $table->string('link_buy')->nullable();
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
        Schema::dropIfExists('products');
    }
}