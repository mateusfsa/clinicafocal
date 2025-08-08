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
        Schema::create('graduacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')->constrained();
            $table->decimal('longe_od_esferico', 5, 2)->nullable();
            $table->decimal('longe_od_cilindrico', 5, 2)->nullable();
            $table->decimal('longe_od_eixo', 5, 2)->nullable();
            $table->decimal('longe_od_dnp', 5, 2)->nullable();
            $table->decimal('longe_oe_esferico', 5, 2)->nullable();
            $table->decimal('longe_oe_cilindrico', 5, 2)->nullable();
            $table->decimal('longe_oe_eixo', 5, 2)->nullable();
            $table->decimal('longe_oe_dnp', 5, 2)->nullable();
            $table->decimal('perto_od_esferico', 5, 2)->nullable();
            $table->decimal('perto_od_cilindrico', 5, 2)->nullable();
            $table->decimal('perto_od_eixo', 5, 2)->nullable();
            $table->decimal('perto_od_dnp', 5, 2)->nullable();
            $table->decimal('perto_oe_esferico', 5, 2)->nullable();
            $table->decimal('perto_oe_cilindrico', 5, 2)->nullable();
            $table->decimal('perto_oe_eixo', 5, 2)->nullable();
            $table->decimal('perto_oe_dnp', 5, 2)->nullable();
            $table->decimal('adicao_od', 5, 2)->nullable();
            $table->decimal('adicao_oe', 5, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduacoes');
    }
};
