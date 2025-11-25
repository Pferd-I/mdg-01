<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('cargo_plantels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_plantel')->constrained('plantels')->onDelete('cascade');
            $table->foreignId('id_cargo')->constrained('cargos')->onDelete('cascade');
            $table->date('fecha_asignacion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_plantels');
    }
};
