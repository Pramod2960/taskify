<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Learning as ModelsLearning;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Taskify')]
class Learning extends Component
{
    use WithPagination;

    // public $tasks;
    public $search;
    public $filter_date;

    public $title, $category, $status;

    protected $rules = [
        'title' => 'required|string',
        'category' => 'required|string',
    ];
    
    public function markAsComplete($id)
    {
        if ($id == null)
            return;
        try {
            $task = ModelsLearning::find($id);
            $task->update(['status' => "completed"]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function save()
    {
        $validated = $this->validate();
        try {
            ModelsLearning::create($validated);
            session()->flash('message', 'Task created successfully.');
            $this->reset(['title', 'category']);
            $this->dispatch('task-saved');
            
            // $this->redirect(route('learning.show'), navigate: true);

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function render()
    {
        try {
            $query = ModelsLearning::orderByRaw("CASE WHEN status = 'completed' THEN 1 ELSE 0 END ASC")
                ->orderBy('updated_at', 'desc');

            if (!empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('body', 'like', '%' . $this->search . '%');
                });
            }
            if (!empty($this->filter_date)) {
                $filterDate = $this->filter_date;
                $query->where(function ($q) use ($filterDate) {
                    $q->where('updated_at', 'like', '%' . $filterDate . '%');
                });
            }

            $tasks = $query->paginate(8);
            // dd($tasks);
            return view('livewire.learning', [
                'tasks' => $tasks,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
