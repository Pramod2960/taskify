<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Taskify')]
#[Layout('layouts.app')]
class TaskList extends Component
{
    use WithPagination;
    public $projects = [];
    public $filter_date, $filter_project;
    public $search;

    public function mount()
    {
        $this->projects = Project::all();
    }

    public function clearFilter()
    {
        $this->search = null;
        $this->filter_date = null;
        $this->filter_project = null;
    }

    public function render()
    {
        try {
            $query = Task::with(['project', 'assigner'])
                ->orderByRaw("
                CASE 
                    WHEN status = 'new'         THEN 1
                    WHEN status = 'pending'     THEN 2
                    WHEN status = 'watching'    THEN 3
                    WHEN status = 'completed'   THEN 4
                    ELSE 0
                    END ASC
                ")
                ->orderBy('created_at', 'desc');

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
            if (!empty($this->filter_project)) {
                $filter_project = $this->filter_project;
                $query->where(function ($q) use ($filter_project) {
                    $q->where('project_id', 'like', '%' . $filter_project . '%');
                });
            }

            $tasks = $query->paginate(20);
            return view('livewire.task-list', [
                'tasks' => $tasks,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
