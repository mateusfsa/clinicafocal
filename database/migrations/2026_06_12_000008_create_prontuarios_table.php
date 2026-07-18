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
        Schema::create('prontuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')->unique()->constrained();

            // Anamnese
            $table->text('queixa_principal');
            $table->text('historia_doenca')->nullable();
            $table->text('antecedentes')->nullable();
            $table->text('medicamentos_em_uso')->nullable();
            $table->text('alergias')->nullable();

            // Exame oftalmológico
            $table->string('av_od_sc', 10)->nullable(); // acuidade visual OD sem correção
            $table->string('av_oe_sc', 10)->nullable();
            $table->string('av_od_cc', 10)->nullable(); // com correção
            $table->string('av_oe_cc', 10)->nullable();
            $table->decimal('pio_od', 4, 1)->nullable(); // tonometria (mmHg)
            $table->decimal('pio_oe', 4, 1)->nullable();
            $table->text('biomicroscopia')->nullable();
            $table->text('fundoscopia')->nullable();

            // Conclusão
            $table->text('diagnostico')->nullable();
            $table->string('cid', 10)->nullable();
            $table->text('conduta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prontuarios');
    }
};
