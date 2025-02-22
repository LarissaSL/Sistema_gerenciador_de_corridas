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
        Schema::create('championships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administrator_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name', 45);
            $table->string('acronym', 5)->nullable();
            $table->date('start_date');
            $table->date('final_date');
            $table->tinyInteger('status')
                ->default(1)
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
        Schema::dropIfExists('championships');
    }
};
