<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use App\Models\Project;
use App\Models\Assigner;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Taskify')]
class CreateTask extends Component
{
    public $title = "", $body = "", $requirment = '';
    public $projects;
    public $assigners;
    public $project_id;
    public $start_date;
    public $assigner_id;
    public $completion_date;

    public function mount()
    {
        $this->projects = Project::all();
        $this->assigners = Assigner::all();
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'requirment' => 'required|string',
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
            $this->reset(['title', 'body', 'requirment', 'project_id', 'assigner_id', 'start_date', 'completion_date']);
            $this->redirect(route('task.list'), navigate: true);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function setBodyContent($value)
    {
        $this->body = $value;
    }
    public function render()
    {
        return view('livewire.create-task');
    }
}
