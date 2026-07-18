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
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_abertura_id')->constrained('users');
            $table->foreignId('user_fechamento_id')->nullable()->constrained('users');
            $table->decimal('valor_abertura', 10, 2)->default(0);
            $table->decimal('valor_fechamento', 10, 2)->nullable();
            $table->timestamp('aberto_em');
            $table->timestamp('fechado_em')->nullable();
            $table->string('status', 10)->default('aberto'); // aberto, fechado
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        Schema::table('pagamentos', function (Blueprint $table) {
            $table->foreignId('caixa_id')->nullable()->after('agendamento_id')
                ->constrained('caixas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('caixa_id');
        });

        Schema::dropIfExists('caixas');
    }
};
