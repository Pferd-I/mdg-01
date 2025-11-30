<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_plantel')->constrained('plantels')->onDelete('cascade');
            $table->foreignId('id_curso')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('id_asignatura')->constrained('asignaturas')->onDelete('cascade');
            $table->date('fecha');
            $table->text('observaciones')->nullable();
            $table->boolean('estado')->default(true);

            $table->unique(['id_plantel', 'id_curso', 'id_asignatura', 'fecha']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('asistencias');
    }
};
