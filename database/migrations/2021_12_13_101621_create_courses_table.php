<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name', 150)->default(null);
            $table->string('short_name', 150)->default(null);
            $table->string('url', 255)->unique();
            $table->text('description')->nullable();
            $table->boolean('available')->default(true);
            $table->text('spotlight')->nullable();
            $table->string('image', 225)->nullable();
            $table->string('file', 225)->nullable();
            $table->string('type', 225);
            $table->string('code', 255)->unique()->default(null);
            $table->time('total_hours');
            $table->boolean('published');
            $table->boolean('free')->default(false);
            $table->double('price', 10, 2);
            $table->double('price_plots', 10, 2)->nullable();
            $table->integer('total_plots')->nullable();
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
        Schema::dropIfExists('courses');
    }
}