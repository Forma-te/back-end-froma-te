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
        Schema::create('ebook_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ebook_id')->unsigned();
            $table->foreign('ebook_id')->references('id')->on('ebooks')->onDelete('cascade');
            $table->string('name', 150)->default(null);
            $table->text('description')->nullable();
            $table->string('file', 225)->nullable();
            $table->boolean('published');
            $table->boolean('free')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_contents');
    }
};
