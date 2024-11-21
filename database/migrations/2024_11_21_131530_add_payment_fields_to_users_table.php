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
        Schema::table('users', function (Blueprint $table) {
            $table->string('titular')->nullable();
            $table->string('account_number')->nullable();
            $table->text('whatsapp')->nullable();
            $table->string('iban')->nullable();
            $table->string('foreign_iban')->nullable();
            $table->string('wise')->nullable();
            $table->string('paypal')->nullable();
            $table->string('user_facebook')->nullable();
            $table->string('user_instagram')->nullable();
            $table->string('proof_path', 2048)->nullable(); // Para armazenar o caminho do ficheiro
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'titular',
                'account_number',
                'whatsapp',
                'iban',
                'foreign_iban',
                'wise',
                'paypal',
                'user_facebook',
                'user_instagram',
                'proof_path'
            ]);
        });
    }
};
