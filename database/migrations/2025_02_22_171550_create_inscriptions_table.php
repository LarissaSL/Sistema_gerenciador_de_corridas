<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('race_id')
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('payment_status' , ['Confirmado', 'Cancelado', 'Em processamento', 'Reembolsado'])
                ->comment('Status: Confirmado, Cancelado, Em processamento, Reembolsado');
            
            $table->tinyInteger('payment_method')
                ->unsigned()
                ->comment('0 - Cartão, 1 - Boleto, 2 - Pix, 3 - Transferência');

            $table->tinyInteger('status')
                ->unsigned()
                ->comment('0 - Inativa, 1 - Ativa');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
