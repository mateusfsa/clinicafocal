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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('registro_ans', 20)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable();
            $table->decimal('valor_consulta', 10, 2)->nullable(); // valor de repasse da consulta
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->foreignId('convenio_id')->nullable()->after('observacoes')
                ->constrained('convenios')->nullOnDelete();
            $table->string('numero_carteirinha', 30)->nullable()->after('convenio_id');
            $table->date('validade_carteirinha')->nullable()->after('numero_carteirinha');
        });

        Schema::table('agendamentos', function (Blueprint $table) {
            // null = particular
            $table->foreignId('convenio_id')->nullable()->after('medico_id')
                ->constrained('convenios')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('convenio_id');
        });

        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('convenio_id');
            $table->dropColumn(['numero_carteirinha', 'validade_carteirinha']);
        });

        Schema::dropIfExists('convenios');
    }
};
