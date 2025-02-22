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
        Schema::create('online_location', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administrator_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('link', 100);
            $table->string('room', 45)->nullable();
            $table->string('room_password', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_location');
    }
};
