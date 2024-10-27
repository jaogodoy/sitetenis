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
        $table->decimal('produto_preco', 8, 2)->after('produto_descricao');
        $table->enum('produto_genero', ['masculino', 'feminino'])->after('produto_preco');
    });
}

public function down(): void
{
    Schema::table('produtos', function (Blueprint $table) {
        $table->dropColumn('produto_preco');
        $table->dropColumn('produto_genero');
    });
}
};
