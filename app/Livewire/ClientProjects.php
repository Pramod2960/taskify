<?php

namespace App\Livewire;

use App\Models\ClientProject as ClientProjectModal;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Taskify')]
#[Layout('layouts.app')]
class ClientProjects extends Component
{
    public $projects;
    public bool $showModal = false;

    public string $name = '';
    public string $description = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];


    public function mount()
    {
        if (auth()->user()->hasRole('superadmin')) {
            $this->projects = ClientProjectModal::withCount([
                'learnings as new_learnings_count' => fn($q) =>
                $q->where('status', '!=', 'completed')
            ])->get();

            return;
        }
        $this->projects = auth()->user()
            ->clientProjects()
            ->withCount([
                'learnings as new_learnings_count' => fn($q) =>
                $q->where('status', '!=', 'completed')
            ])
            ->get();
    }

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
        return view('livewire.client-projects');
    }
}
