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
        Schema::create('platform_balances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('courses')->onDelete('cascade');
            $table->decimal('product_value', 10, 2); // Valor do produto
            $table->decimal('product_percentage', 10, 2);
            $table->decimal('total_balance', 10, 2)->default(0); // Saldo total da plataforma
            $table->decimal('available_balance', 10, 2)->default(0); // Saldo disponível para retirada
            $table->decimal('pending_balance', 10, 2)->default(0); // Saldo pendente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_balances');
    }
};
