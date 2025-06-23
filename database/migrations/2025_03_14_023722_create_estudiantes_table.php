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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('ci')->default('0');
            $table->string('rude')->default('0');
            $table->string('apellido_p');
            $table->string('apellido_m');
            $table->string('nombres');
            $table->integer('id_tipo_beca')->default(1);
            $table->integer('id_curso')->default(1);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
