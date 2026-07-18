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
        Schema::table('pacientes', function (Blueprint $table) {
            $table->boolean('consentimento_lgpd')->default(false)->after('observacoes');
            $table->timestamp('consentimento_lgpd_em')->nullable()->after('consentimento_lgpd');
        });

        Schema::table('solicitacoes_agendamento', function (Blueprint $table) {
            $table->boolean('consentimento')->default(false)->after('mensagem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn(['consentimento_lgpd', 'consentimento_lgpd_em']);
        });

        Schema::table('solicitacoes_agendamento', function (Blueprint $table) {
            $table->dropColumn('consentimento');
        });
    }
};
