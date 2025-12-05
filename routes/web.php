<?php

use App\Livewire\Task;
use App\Livewire\Learning;
use App\Livewire\TaskList;
use App\Livewire\Dashboard;
use App\Livewire\CreateTask;
use App\Livewire\Admin\AddProject;
use App\Livewire\FormBuilder\FormBuilder;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', Dashboard::class)->middleware('auth')->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::name('task.')->group(function () {
    Route::get('/create-task', CreateTask::class)->name('create');
    Route::get('/tasks', TaskList::class)->name('list');
    Route::get('/task/{task}', Task::class)->name('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/add-project', AddProject::class)->name('project.create');
});

Route::name('learning.')->group(function () {
    Route::get('/learning', Learning::class)->name('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/form-builder', FormBuilder::class)->name('form-builder');
});

require __DIR__ . '/auth.php';




