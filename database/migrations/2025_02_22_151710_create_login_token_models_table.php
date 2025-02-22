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
        Schema::create('login_token', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administrator_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('token', 10);
            $table->tinyInteger('status')
                ->unsigned()
                ->default(0)
                ->comment('0 - Não usado, 1 - Usado, 2 - Bloqueado');
            $table->tinyInteger('attempt')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_token');
    }
};
