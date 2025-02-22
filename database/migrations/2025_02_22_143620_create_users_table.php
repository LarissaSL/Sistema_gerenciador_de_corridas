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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->string('last_name', 45)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 50)->unique();
            $table->string('password', 200);
            $table->tinyInteger('status')
                ->unsigned()
                ->default(1)
                ->comment('0 - Inativo, 1 - Ativo, 2 - Bloqueado');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
