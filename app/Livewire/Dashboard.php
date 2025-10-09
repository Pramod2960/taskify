<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Taskify')]
class Dashboard extends Component
{
    public $watching, $completed, $newCount;

    public function mount()
    {
        $this->completed = Task::where('status', 'completed')->count();
        $this->watching = Task::where('status', 'watching')->count();
        $this->newCount = Task::where('status', 'new')->count();
        $this->newCount = Task::where('status', 'pending')->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
