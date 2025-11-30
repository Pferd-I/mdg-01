<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('asistencia_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_asistencia');
            $table->foreign('id_asistencia')->references('id')->on('asistencias')->onDelete('cascade');
            $table->unsignedBigInteger('id_estudiante');
            $table->foreign('id_estudiante')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->enum('valor', ['Presente','Ausente','Atraso','Justificado'])
                  ->default('Presente');
            $table->text('observacion_individual')->nullable();
            $table->boolean('estado')->default(true);

            $table->unique(['id_asistencia', 'id_estudiante']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_detalles');
    }
};
