<?php

use App\Livewire\CreateTask;
use App\Livewire\Learning;
use App\Livewire\Task;
use App\Livewire\TaskList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->name('task.')->group(function () {
    Route::get('/create-task', CreateTask::class)->name('create');
    Route::get('/tasks', TaskList::class)->name('list');
    Route::get('/task/{task}', Task::class)->name('show');
});

Route::middleware('auth')->name('learning.')->group(function () {
    Route::get('/learning', Learning::class)->name('show');
});

require __DIR__ . '/auth.php';
