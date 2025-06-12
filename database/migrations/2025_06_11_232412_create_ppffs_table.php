<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ppffs', function (Blueprint $table) {
            $table->id();
            $table->string('cionit');            //CI o NIT
            $table->string('nombre');
            $table->string('direccion')->default("S/N");
            $table->string('telf')->default('0');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppffs');
    }
};
