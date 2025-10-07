<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Taskify')]
class TaskList extends Component
{
    public $tasks;
    public $filter_date;
    public $search;


    public function mount() {}

    public function clearFilter()
    {
        $this->search = null;
        $this->filter_date = null;
    }

    public function render()
    {
        try {
            $query = Task::with(['project', 'assigner'])
                ->orderByRaw("
                CASE 
                    WHEN status = 'watching' THEN 1
                    WHEN status = 'completed' THEN 2
                    ELSE 0
                    END ASC
                ")
                ->orderBy('updated_at', 'desc');

            if (!empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('body', 'like', '%' . $this->search . '%')
                        ->orWhereHas('project', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('assigner', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            }

            if (!empty($this->filter_date)) {
                $filterDate = $this->filter_date;
                $query->where(function ($q) use ($filterDate) {
                    $q->where('updated_at', 'like', '%' . $filterDate . '%');
                });
            }

            $this->tasks = $query->get();
            return view('livewire.task-list', [
                'tasks' => $this->tasks,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
