<?php

namespace App\Livewire\Admin;

use App\Models\TeamMember;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamMembersManager extends Component
{
    use WithFileUploads;

    public $members, $name, $role, $crm, $image, $linkedin, $instagram, $email, $member_id;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'crm' => 'nullable|string|max:255',
        'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        'linkedin' => 'nullable|url',
        'instagram' => 'nullable|url',
        'email' => 'nullable|email',
    ];

    public function mount()
    {
        $this->loadMembers();
    }

    public function loadMembers()
    {
        $this->members = TeamMember::orderBy('id', 'desc')->get();
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->modalFormVisible = true;
    }

    public function showEditModal($id)
    {
        $member = TeamMember::findOrFail($id);
        $this->member_id = $id;
        $this->name = $member->name;
        $this->role = $member->role;
        $this->crm = $member->crm;
        $this->linkedin = $member->linkedin;    
        $this->instagram = $member->instagram;
        $this->email = $member->email;
        $this->modalFormVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->member_id) {
            $member = TeamMember::find($this->member_id);
        } else {
            $member = new TeamMember();
        }

        $member->fill([
            'name' => $this->name,
            'role' => $this->role,
            'crm' => $this->crm,
            'linkedin' => $this->linkedin,
            'instagram' => $this->instagram,
            'email' => $this->email,
        ]);

        // Upload de imagem
        if ($this->image) {
            $path = $this->image->store('team', 'public');
            $member->image = $path;
        }

        $member->save();

        $this->modalFormVisible = false;
        $this->resetForm();
        $this->loadMembers();
        session()->flash('message', 'Membro da equipe salvo com sucesso.');
    }

    public function confirmDelete($id)
    {
        $this->member_id = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function delete()
    {
        TeamMember::destroy($this->member_id);
        $this->modalConfirmDeleteVisible = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->member_id = null;
        $this->name = '';
        $this->role = '';
        $this->crm = '';
        $this->image = null;
        $this->linkedin = '';
        $this->instagram = '';
        $this->email = '';
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.team-members-manager');
    }
}
