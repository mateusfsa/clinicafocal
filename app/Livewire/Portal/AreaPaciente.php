<?php

namespace App\Livewire\Portal;

use App\Livewire\Actions\Logout;
use App\Models\Agendamento;
use App\Models\Paciente;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.portal')]
class AreaPaciente extends Component
{
    public Paciente $paciente;

    public function mount()
    {
        $user = auth()->user();

        abort_unless($user && $user->isPaciente() && $user->paciente, 403);

        $this->paciente = $user->paciente;
    }

    public function logout(Logout $logout)
    {
        $logout();

        return redirect('/');
    }

    public function render()
    {
        $proximas = $this->paciente->agendamentos()
            ->with('medico')
            ->where('data_hora', '>=', now())
            ->where('status', '!=', Agendamento::STATUS_CANCELADO)
            ->orderBy('data_hora')
            ->get();

        $historico = $this->paciente->agendamentos()
            ->with('medico')
            ->where('data_hora', '<', now())
            ->orderByDesc('data_hora')
            ->limit(20)
            ->get();

        $documentos = $this->paciente->agendamentos()
            ->with(['receita', 'graduacoe', 'medico'])
            ->where(function ($q) {
                $q->whereHas('receita')->orWhereHas('graduacoe');
            })
            ->orderByDesc('data_hora')
            ->get();

        return view('livewire.portal.area-paciente', [
            'proximas' => $proximas,
            'historico' => $historico,
            'documentos' => $documentos,
        ]);
    }
}
