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
        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 10); // pagar, receber
            $table->string('descricao');
            $table->string('categoria', 50)->nullable();
            $table->decimal('valor', 10, 2);
            $table->date('vencimento');
            $table->date('pago_em')->nullable();
            $table->string('forma_pagamento', 20)->nullable();
            // Origem do recebível (opcional)
            $table->foreignId('paciente_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('convenio_id')->nullable()->constrained('convenios')->nullOnDelete();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index(['tipo', 'vencimento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas');
    }
};
