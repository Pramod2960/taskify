<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Layout;
use App\Models\Task as ModelsTask;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Taskify')]
class Task extends Component
{
    #[Locked]
    public $id;

    public $task;
    public $title, $body;
    public $isEdit = false;

    public function mount(ModelsTask $task)
    {
        $this->task = $task;
        try {
            $this->fill(
                $task->only('title', 'body'),
            );
            $this->id = $task->id;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function save()
    {
        if ($this->id == null)
            return;
        try {
            $this->task->update([
                'title'  => $this->title,
                'body'   => $this->body,
            ]);
            session()->flash('message', 'Task saved successfully.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }



    public function markComplete($statusType)
    {
        if ($this->id == null)
            return;
        try {
            $this->save();
            $this->task->update(['status' => $statusType]);
            $this->redirect(route('task.list'), navigate: true);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.task');
    }
}
