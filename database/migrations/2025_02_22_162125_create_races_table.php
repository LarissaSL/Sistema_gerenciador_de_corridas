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
        Schema::create('races', function (Blueprint $table) {
            $table->id();

            $table->foreignId('administrator_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('location_id')
                ->nullable()
                ->constrained('locations')
                ->nullOnDelete()
                ->comment('Caso nulo é corrida Online');

            $table->foreignId('online_location_id')
                ->nullable()
                ->constrained('online_location')
                ->nullOnDelete()
                ->comment('Caso nulo é corrida presencial');

            $table->foreignId('championship_id')
                ->nullable()
                ->constrained('championships')
                ->nullOnDelete()
                ->comment('Caso nulo é corrida Avulsa');

            $table->string('name', 45);
            $table->date('date');
            $table->time('time');

            $table->enum('category', ['Feminino', 'Masculino', 'Livre'])
                ->comment('Categorias: Feminino, Masculino e Livre');

            $table->decimal('price', 8, 2);

            $table->tinyInteger('status')
                ->unsigned()
                ->default(1)
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
        Schema::dropIfExists('races');
    }
};
