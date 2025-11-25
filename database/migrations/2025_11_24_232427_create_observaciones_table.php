<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_plantel')->constrained('plantels')->onDelete('restrict');
            $table->foreignId('id_estudiante')->constrained('estudiantes')->onDelete('cascade');
            $table->string('tipo');
            $table->text('descripcion');
            $table->foreignId('id_curso')->nullable()->constrained('cursos')->onDelete('set null');
            $table->string('asignatura')->nullable();
            $table->date('fecha_evento');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observaciones');
    }
};
