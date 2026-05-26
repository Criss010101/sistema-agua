<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->decimal('lectura_inicial', 10, 2)->default(0);
    });
}

public function down()
{
    Schema::table('usuarios', function (Blueprint $table) {
        $table->dropColumn('lectura_inicial');
    });
}
};
