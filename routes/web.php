<?php

use App\Livewire\CreateTask;
use App\Livewire\Dashboard;
use App\Livewire\Learning;
use App\Livewire\Task;
use App\Livewire\TaskList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('dashboard', Dashboard::class)->middleware('auth')->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::name('task.')->group(function () {
    Route::get('/create-task', CreateTask::class)->name('create');
    Route::get('/tasks', TaskList::class)->name('list');
    Route::get('/task/{task}', Task::class)->name('show');
});

Route::name('learning.')->group(function () {
    Route::get('/learning', Learning::class)->name('show');
    });

require __DIR__ . '/auth.php';
    