<?php

use App\Models\Graduacoe;
use App\Models\Receita;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// O CMS do site agora fica no painel administrativo, no grupo "Site" (/admin/site/...)

Route::middleware('auth')->group(function () {
    // Documento visível para a equipe ou para o próprio paciente
    $podeVerDocumento = function (int $pacienteId): bool {
        $user = auth()->user();

        return $user->isStaff()
            || ($user->isPaciente() && $user->paciente?->id === $pacienteId);
    };

    Route::get('/print/graduacao/{graduacoe}', function (Graduacoe $graduacoe) use ($podeVerDocumento) {
        abort_unless($podeVerDocumento($graduacoe->agendamento->paciente_id), 403);

        return view('prints.graduacao', ['graduacoe' => $graduacoe]);
    })->name('print.graduacao');

    Route::get('/print/receita/{receita}', function (Receita $receita) use ($podeVerDocumento) {
        abort_unless($podeVerDocumento($receita->agendamento->paciente_id), 403);

        return view('prints.receita', ['receita' => $receita]);
    })->name('print.receita');

    // Portal do Paciente
    Route::get('/portal', \App\Livewire\Portal\AreaPaciente::class)->name('portal');

    // Pós-login: paciente vai ao portal, equipe vai ao painel
    Route::get('/dashboard', function () {
        return auth()->user()->isPaciente()
            ? redirect()->route('portal')
            : redirect('/admin');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
