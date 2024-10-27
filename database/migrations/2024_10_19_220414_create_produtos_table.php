<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{



    public function up(): void
{
    if (!Schema::hasTable('produtos')) {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->onDelete('cascade');
            $table->string('produto_nome');
            $table->integer('produto_quantidade');
            $table->text('produto_descricao')->nullable();
            $table->boolean('produto_ativo')->default(1);
            $table->timestamps();
        });
    }
}


    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
