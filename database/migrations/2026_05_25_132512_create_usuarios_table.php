<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('comunidad_id')->constrained('comunidades')->onDelete('cascade');
        $table->integer('codigo_socio'); // 1, 2, 3... secuencial por comunidad
        $table->string('nombre');
        $table->string('codigo_medidor')->unique(); // El número físico del aparato
        $table->timestamps();
        
        // Evita que se repita el mismo código de socio dentro de la misma comunidad
        $table->unique(['comunidad_id', 'codigo_socio']);
     });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};