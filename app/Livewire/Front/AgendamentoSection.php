<?php

namespace App\Livewire\Front;

use App\Models\Medico;
use App\Models\SolicitacaoAgendamento;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class AgendamentoSection extends Component
{
    public $medicos = [];

    public $nome;
    public $email;
    public $telefone;
    public $medico_id;
    public $data_preferida;
    public $periodo = 'manha';
    public $mensagem;
    public $consentimento = false;

    public function mount()
    {
        $this->medicos = Medico::ativos()->orderBy('nome')->get();
    }

    protected function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'medico_id' => 'nullable|exists:medicos,id',
            'data_preferida' => 'required|date|after_or_equal:today',
            'periodo' => 'required|in:manha,tarde',
            'mensagem' => 'nullable|string|max:500',
            'consentimento' => 'accepted',
        ];
    }

    protected $messages = [
        'consentimento.accepted' => 'É necessário autorizar o uso dos seus dados para agendarmos a consulta.',
    ];

    protected $validationAttributes = [
        'nome' => 'nome',
        'email' => 'e-mail',
        'telefone' => 'telefone',
        'medico_id' => 'médico',
        'data_preferida' => 'data',
        'periodo' => 'período',
    ];

    public function solicitar()
    {
        // Proteção simples contra abuso: 5 solicitações por hora por IP
        $key = 'solicitar-agendamento:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('nome', 'Muitas solicitações. Tente novamente mais tarde.');

            return;
        }
        RateLimiter::hit($key, 3600);

        $this->validate();

        SolicitacaoAgendamento::create([
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'medico_id' => $this->medico_id ?: null,
            'data_preferida' => $this->data_preferida,
            'periodo' => $this->periodo,
            'mensagem' => $this->mensagem,
            'consentimento' => true,
            'status' => SolicitacaoAgendamento::STATUS_PENDENTE,
        ]);

        $this->reset(['nome', 'email', 'telefone', 'medico_id', 'data_preferida', 'mensagem', 'consentimento']);
        $this->periodo = 'manha';

        session()->flash('agendamento_success', 'Solicitação enviada! Entraremos em contato para confirmar seu horário.');
    }

    public function render()
    {
        return view('livewire.front.agendamento-section');
    }
}
