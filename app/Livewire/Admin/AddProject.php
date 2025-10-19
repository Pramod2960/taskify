<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Title('Add Project')]
#[Layout('layouts.app')]
class AddProject extends Component
{

    #[Validate('required', message: 'Project Name is requeried')]
    public $name;

    public $showToast = false,  $toastMessage = '', $toastType;

    public function saveProject()
    {
        $this->validate();
        try {
            Project::create([
                'name' => $this->name,
            ]);
            $this->reset(['name']);
            $this->showToast("Project created successfully!", "success");

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function showToast($message, $type)
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->showToast = true;
    }

    public function render()
    {
        return view('livewire.admin.add-project');
    }
}
