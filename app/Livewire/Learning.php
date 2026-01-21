<?php

namespace App\Livewire;

use App\Models\ClientProject;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Learning as ModelsLearning;

#[Title('Taskify')]
#[Layout('layouts.app')]
class Learning extends Component
{
    use WithPagination;

    public $project_id = null, $project_name;
    // public $tasks;
    public $search;
    public $filter_date;
    public $showModal = false;
    public $showToast = false,  $toastMessage = '', $toastType;
    public $userAssignToThisProject = [];

    public $title, $category, $status;

    protected $rules = [
        'title' => 'required|string',
        // 'category' => 'required|string',
        'status' => 'required|string'
    ];

    public function mount($project)
    {
        $this->project_id = $project;
        $projectModel = ClientProject::with('users:id,name')->findOrFail($project);
       
        $this->project_name = $projectModel->name;
        $this->userAssignToThisProject = $projectModel->users;
    }

    public function markAsComplete($id)
    {
        if ($id == null)
            return;
        try {
            $task = ModelsLearning::find($id);
            $task->update(['status' => "completed"]);
            $this->showToast("Great Job!", "success");
            $this->js('hideToast');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function linkClick($id)
    {
        try {
            $task = ModelsLearning::find($id);
            $this->title = $task->title;
            $this->category = $task->category;
            $this->showModal = true;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function save()
    {
        $validated = $this->validate();
        try {
            ModelsLearning::create([
                'title'      => $this->title,
                'project_id' => $this->project_id,
                'status'     => $this->status,
            ]);
            // $this->reset(['title', 'category']);
            $this->showModal = false;
            $this->showToast("Task created successfully!", "success");
            $this->js('hideToast');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function addNewTask()
    {
        $this->title = "";
        $this->category = "";
        $this->showModal = true;
    }

    public function copy($data)
    {
        $this->js('copy', text: $data);
        $this->showToast("Copied to clipboard", "success");
        $this->js('hideToast', text: $data);
        // $this->dispatchBrowserEvent('hide-toast');
    }

    public function showToast($message, $type)
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->showToast = true;
    }

    public function clearFilter($data)
    {
        $this->search = "";
    }

    public function handleCancle()
    {
        $this->title = "";
        $this->category = "";
        $this->showModal = false;
    }

    public function render()
    {
        try {
            $query = ModelsLearning::orderByRaw("
            CASE 
            WHEN status = 'core' THEN 1
            WHEN status = 'ui' THEN 2
            WHEN status = 'new' THEN 3
            WHEN status = 'completed' THEN 4 
            ELSE 0 END ASC")
                ->orderBy('updated_at', 'asc')
                ->where('project_id',  $this->project_id);

            if (!empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                });
            }
            if (!empty($this->filter_date)) {
                $filterDate = $this->filter_date;
                $query->where(function ($q) use ($filterDate) {
                    $q->where('updated_at', 'like', '%' . $filterDate . '%');
                });
            }

            // $queryNew = $query;
            // $newCount = $queryNew->where('status', 'new')->count();
            // $pagination = max(20, $newCount);

            $tasks = $query->paginate(20);
            return view('livewire.learning', [
                'tasks' => $tasks,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
