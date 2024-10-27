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
    Schema::table('produtos', function (Blueprint $table) {
        $table->string('produto_imagem')->nullable(); // Campo para a imagem
    });
}

public function down(): void
{
    Schema::table('produtos', function (Blueprint $table) {
        $table->dropColumn('produto_imagem'); // Remove o campo na reversão
    });
}
};
