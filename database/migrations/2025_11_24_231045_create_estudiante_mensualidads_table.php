<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('estudiante_mensualidads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_estudiante')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('id_mensualidad')->constrained('mensualidads')->onDelete('cascade');
            $table->decimal('monto_a_cobrar', 8, 2);
            $table->decimal('saldo', 8, 2);
            $table->boolean('pagado')->default(true);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('estudiante_mensualidads');
    }
};
