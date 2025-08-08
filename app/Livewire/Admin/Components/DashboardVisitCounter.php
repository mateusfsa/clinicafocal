<?php

namespace App\Livewire\Admin\Components;

use App\Models\Visit;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class DashboardVisitCounter extends Component
{
    public $visits, $visitsToday = 0;

    public function mount()
    {
        $ip = Request::ip();
        $today = Carbon::today()->toDateString();

        // Só conta se ainda não visitou hoje
        $alreadyVisited = Visit::where('ip', $ip)
            ->where('date', $today)
            ->exists();


        if (!$alreadyVisited) {
            Visit::insert([
                'ip' => $ip,
                'date' => $today,
            ]);
        }

        // Conta número de IPs únicos hoje
        $this->visits = Visit::count();
        $this->visitsToday = Visit::where('date', $today)->count();
    }

    public function render()
    {
        return view('livewire.admin.components.dashboard-visit-counter');
    }
}
