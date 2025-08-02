<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('tipo_becas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tipo_beca');
            $table->string('descripcion');
            $table->decimal('dcto',5,2)->default(0);  //Porcentaje de dcto
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('tipo_becas');
    }
};
