<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('mensualidads', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_mes');
            $table->string('nombre_mes');
            $table->foreignId('id_gestion')->constrained('gestions');     //Foreign Gestion
            $table->decimal('monto', 6, 2);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensualidads');
    }
};
