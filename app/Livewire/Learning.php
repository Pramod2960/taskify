<?php

namespace App\Livewire;

use App\Models\ClientProject;
use App\Models\File;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Learning as ModelsLearning;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;

#[Title('Taskify')]
#[Layout('layouts.app')]
class Learning extends Component
{
    use WithPagination, WithFileUploads;

    public $project_id = null, $project_name;
    // public $tasks;
    public $search;
    public $filter_date;

    public $modaltype = null;
    public $showModal = false;
    public $showToast = false,  $toastMessage = '', $toastType;
    public $assigned_to, $userAssignToThisProject = [];
    public $pendingTaskCount, $completedTaskCount;

    public $title, $category, $status;
    public $selectedTask = null;


    public $photo;
    public $existingFiles = [];

    protected $rules = [
        'title' => 'required|string',
        'status' => 'required|string',
        'assigned_to' => 'required|exists:users,id',
        'photo' => 'nullable|image|max:10240', // 10MB
    ];

    public function mount($project)
    {

        $this->project_id = $project;
        $projectModel = ClientProject::with('users:id,name')->findOrFail($project);

        $this->project_name = $projectModel->name;

        $this->userAssignToThisProject = $projectModel->users;
        $this->assigned_to = auth()->id();
    }

    #[Computed]
    public function count()
    {
        return [
            'completed' => ModelsLearning::where('status', 'completed')->where('project_id', $this->project_id)->count(),
            'not_completed' => ModelsLearning::where('status', '!=', 'completed')->where('project_id', $this->project_id)->count(),
        ];
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

    public function handleAddNewTask()
    {
        $this->photo = null;
        $this->modaltype = "add";
        $this->showModal = true;
    }

    public function linkClick($id)
    {
        $this->modaltype = "view";
        try {
            $task = ModelsLearning::with('files')->findOrFail($id);

            $this->title = $task->title;
            $this->category = $task->category;
            $this->status = $task->status;
            $this->existingFiles = $task->files;

            $this->showModal = true;
            $this->selectedTask = $task;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function save()
    {
        $validated = $this->validate();

        try {
            if ($this->selectedTask) {

                $this->selectedTask->title = $this->title;
                $this->selectedTask->project_id = $this->project_id;
                $this->selectedTask->status = $this->status;
                $this->selectedTask->assigned_to =  $this->assigned_to;
                $this->selectedTask->save();

                $this->selectedTask = null;
                $this->handleCancle();

                $this->showToast("Task Updated successfully!", "success");
            } else if ($this->selectedTask === null) {
                $task = ModelsLearning::create([
                    'title'      => $this->title,
                    'project_id' => $this->project_id,
                    'status'     => $this->status,
                    'assigned_to' => $this->assigned_to,
                ]);
                // $this->reset(['title', 'category']);
                $this->showModal = false;

                $this->assigned_to = auth()->id();

                if ($this->photo) {
                    $path = $this->photo->store('learning-files', 'public');
                    File::create([
                        'learning_id' => $task->id,
                        'file_name'   => $this->photo->getClientOriginalName(),
                        'file_path'   => $path,
                        'mime_type'   => $this->photo->getMimeType(),
                        'file_size'   => $this->photo->getSize(),
                    ]);
                }

                $this->title = "";
                $this->category = "";
                $this->status = "";
                $this->photo = null;

                $this->showToast("Task created successfully!", "success");
                $this->js('hideToast');
            }
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
        $this->modaltype = null;
        $this->title = "";
        $this->category = "";
        $this->status = "";
        $this->assigned_to = auth()->id();

        $this->selectedTask = null;
        $this->showModal = false;
    }

    public function render()
    {
        try {
            $userId = auth()->id();

            $query = ModelsLearning::where('project_id', $this->project_id)
                ->orderByRaw("
        CASE
            WHEN status = 'completed' THEN 3
            WHEN assigned_to = ? THEN 0
            WHEN assigned_to IS NULL THEN 1
            ELSE 2
        END,
        CASE
            WHEN assigned_to = ? AND status = '1' THEN 0
            WHEN assigned_to = ? AND status = '2' THEN 1
            WHEN assigned_to = ? AND status = '3' THEN 2
            ELSE 3
        END
    ", [$userId, $userId, $userId, $userId])
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

            $tasks = $query->paginate(50);
            return view('livewire.learning', [
                'tasks' => $tasks,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function deleteProject()
    {
        try {
            $project = ClientProject::with('learnings')->findOrFail($this->project_id);
            $project->learnings()->delete();
            $project->delete();
            $this->showToast("Project deleted successfully", "success");

            return redirect()->route('learning.portal');
        } catch (\Throwable $th) {
            $this->showToast("Unable to delete project", "error");
            $this->js('hideToast');
        }
    }
}


