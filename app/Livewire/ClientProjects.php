<?php

namespace App\Livewire;

use App\Models\ClientProject as ClientProjectModal ;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Taskify')]
#[Layout('layouts.app')]
class ClientProjects extends Component
{
    public bool $showModal = false;

    public string $name = '';
    public string $description = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function createProject()
    {
        $this->validate();

        ClientProjectModal::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset(['name', 'description', 'showModal']);
    }

    public function render()
    {
        return view('livewire.client-projects', [
            'projects' => ClientProjectModal::all(),
        ]);
    }
}
