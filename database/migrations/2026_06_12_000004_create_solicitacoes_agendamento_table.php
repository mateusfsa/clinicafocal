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
        Schema::create('solicitacoes_agendamento', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('telefone', 20);
            $table->foreignId('medico_id')->nullable()->constrained('medicos')->nullOnDelete();
            $table->date('data_preferida');
            $table->string('periodo', 10); // manha, tarde
            $table->text('mensagem')->nullable();
            $table->string('status', 20)->default('pendente'); // pendente, confirmada, recusada
            // Agendamento criado a partir desta solicitação (quando confirmada)
            $table->foreignId('agendamento_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_agendamento');
    }
};
