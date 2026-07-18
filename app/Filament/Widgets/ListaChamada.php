<?php

namespace App\Filament\Widgets;

use App\Models\Agendamento;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class ListaChamada extends Widget
{
    protected static string $view = 'filament.widgets.lista-chamada';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'agendamentos' => Agendamento::with(['paciente', 'medico'])
                ->hoje()
                ->whereIn('status', [
                    Agendamento::STATUS_AGENDADO,
                    Agendamento::STATUS_COMPARECEU,
                    Agendamento::STATUS_EM_ATENDIMENTO,
                ])
                ->orderBy('data_hora')
                ->get(),
        ];
    }

    public function checkin(int $id): void
    {
        $this->mudarStatus($id, Agendamento::STATUS_AGENDADO, Agendamento::STATUS_COMPARECEU, 'Check-in realizado.');
    }

    public function iniciar(int $id): void
    {
        $this->mudarStatus($id, Agendamento::STATUS_COMPARECEU, Agendamento::STATUS_EM_ATENDIMENTO, 'Atendimento iniciado.');
    }

    public function finalizar(int $id): void
    {
        $this->mudarStatus($id, Agendamento::STATUS_EM_ATENDIMENTO, Agendamento::STATUS_FINALIZADO, 'Atendimento finalizado.');
    }

    private function mudarStatus(int $id, string $de, string $para, string $mensagem): void
    {
        $agendamento = Agendamento::find($id);

        if (! $agendamento || $agendamento->status !== $de) {
            return;
        }

        $agendamento->update(['status' => $para]);

        Notification::make()->title($mensagem)->success()->send();
    }
}
