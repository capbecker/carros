<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *  A adoção de enums no lugar de string para os campos de combustivel e cambio foi adotado para 
     *  evitar problemas de incompatibilidade de dados gerados por falta de padrão.
     *  Por exemplo, caso o 1º mockup forneça o cambio "automatico" e o 2º forneça "automática", tecnicamente
     *  são informações distintas, mesmo que ambos se refiram ao cambio Automático.
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id(); 
            $table->integer('codigoVeiculo')->unique(); 
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->onDelete('cascade'); 
            $table->string('marca', 500); 
            $table->string('modelo', 500); 
            $table->year('ano')->nullable();; 
            $table->string('versao', 500)->nullable();
            $table->string('cor', 300)->nullable();
            $table->integer('km')->nullable();        
            $table->enum('combustivel', ['Gasolina', 'Álcool', 'Diesel', 'Elétrico', 'Híbrido', 'Flex'])->nullable();
            $table->enum('cambio', ['Manual', 'Automático'])->nullable();
            $table->integer('portas')->nullable(); 
            $table->decimal('preco', 20, 2)->nullable();
            $table->dateTime('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
};
