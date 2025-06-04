<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('mensualidad__estudiantes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_estudiante');
            $table->integer('id_mensualidad');
            $table->decimal('monto_a_cobrar');      //monto calculado de Mensualidad.monto * (1-dcto)
            $table->decimal('saldo');               //monto que falta cobrar de esta mensualidad
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('mensualidad__estudiantes');
    }
};
