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
    public $title, $body, $requirment;
    public $isEdit = false;

    protected function rules()
    {
        return [
            'title' => 'required|min:3',
            'body' => 'required|min:3',
        ];
    }

    public function mount(ModelsTask $task)
    {
        $this->task = $task;
        try {
            $this->fill($task->only('title', 'body', 'requirment'));
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
            $this->validate();
            $this->task->update([
                'title'  => $this->title,
                'requirment' => $this->requirment,
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

    public function back()
    {
        try {
            $this->task->body = $this->body;
            $dirty = $this->task->isDirty('title', 'body');
            if ($dirty)
                $this->save();

            $this->redirect(route('task.list'), navigate: true);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function markDelete(ModelsTask $task)
    {
        try {
            // $this->authorize('delete', $task);
            $task->delete();
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
