<?php

namespace App\Livewire;

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

    // public $tasks;
    public $search;
    public $filter_date;
    public $showModal = false;
    public $showToast = false,  $toastMessage = '', $toastType;


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
            ModelsLearning::create($validated);
            $this->reset(['title', 'category']);
            $this->showModal = false;
            $this->showToast("Task created successfully! sdadasdsa dasdsa das dsad", "success");
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
            WHEN status = 'new' THEN 1
            WHEN status = 'completed' THEN 2 
            ELSE 0 END ASC")
                ->orderBy('updated_at', 'asc');

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
