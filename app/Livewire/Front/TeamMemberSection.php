<?php

namespace App\Livewire\Front;

use App\Models\TeamMember;
use Livewire\Component;

class TeamMemberSection extends Component
{
    public $members;
    
    public function mount()
    {
        $this->loadMembers();
    }

    public function loadMembers()
    {
        $this->members = TeamMember::orderBy('id', 'desc')->get();
    }
    public function render()
    {
        return view('livewire.front.team-member-section');
    }
}
