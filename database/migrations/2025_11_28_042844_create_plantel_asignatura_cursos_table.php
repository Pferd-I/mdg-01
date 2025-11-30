<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('plantel_asignatura_cursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_plantel');
            $table->foreign('id_plantel')->references('id')->on('plantels')->onDelete('cascade');
            $table->unsignedBigInteger('id_asignatura');
            $table->foreign('id_asignatura')->references('id')->on('asignaturas')->onDelete('cascade');
            $table->unsignedBigInteger('id_curso');
            $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('cascade');
            $table->boolean('estado')->default(true);

            $table->unique(['id_plantel','id_asignatura','id_curso'], 'unique_plantel_asignatura_cursos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantel_asignatura_cursos');
    }
};
