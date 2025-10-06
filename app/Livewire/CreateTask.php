<?php

namespace App\Livewire;

use App\Models\Assigner;
use App\Models\Task;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Taskify')]
class CreateTask extends Component
{
    public $title;
    public $body;
    public $project_id;
    public $start_date;
    public $completion_date;
    public $projects;
    public $assigners;
    public $assigner_id;

    public function mount()
    {
        $this->projects = Project::all();
        $this->assigners = Assigner::all();
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'project_id' => 'required|exists:projects,id',
        'assigner_id' => 'required|exists:assigners,id',
        'start_date' => 'required|date',
        'completion_date' => 'nullable|date|after_or_equal:start_date',
    ];

    public function save()
    {
        $validated = $this->validate();
        try {
            Task::create($validated);
            session()->flash('message', 'Task created successfully.');
            $this->reset(['title', 'body', 'project_id','assigner_id', 'start_date', 'completion_date']);
            $this->redirect(route('task.list'), navigate:true);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.create-task');
    }
}
