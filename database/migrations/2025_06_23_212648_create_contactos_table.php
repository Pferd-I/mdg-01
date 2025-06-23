<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        // 'id_dueno' vendrán de las columnas 'id' de las tablas Ppffs y Plantel.
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_dueno');   //1:plantel, 2:ppff
            $table->integer('id_dueno');
            $table->string('telf');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
