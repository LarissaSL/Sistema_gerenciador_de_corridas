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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administrator_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name', 45);
            $table->string('street', 45);
            $table->string('number', 10);
            $table->string('neighborhood', 45);
            $table->string('cep', 10);
            $table->string('state', 45);
            $table->tinyInteger('status')
                ->default(1)
                ->unsigned()
                ->comment('0 - Inativo, 1 - Ativo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
