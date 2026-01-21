<?php

use App\Livewire\Task;
use App\Livewire\Learning;
use App\Livewire\TaskList;
use App\Livewire\Dashboard;
use App\Livewire\CreateTask;
use App\Livewire\ClientProjects;
use App\Livewire\Admin\AddProject;
use Illuminate\Support\Facades\Route;
use App\Livewire\FormBuilder\FormBuilder;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::name('task.')->group(function () {
        Route::get('/create-task', CreateTask::class)->name('create');
        Route::get('/tasks', TaskList::class)->name('list');
        Route::get('/task/{task}', Task::class)->name('show');
    });

    Route::get('/learning', ClientProjects::class)->name('learning.portal');
    Route::get('/add-project', AddProject::class)->name('project.create');
    Route::get('/learning/{project}', Learning::class)->name('learning.project');
    Route::get('/form-builder', FormBuilder::class)->name('form-builder');
});



require __DIR__ . '/auth.php';
