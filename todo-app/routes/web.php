<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', [TodoController::class, 'index'])->name('todos.index');
Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');

Route::patch('/todos/{todo}/done', [TodoController::class, 'done'])->name('todos.done');
Route::patch('/todos/{todo}/undo', [TodoController::class, 'undo'])->name('todos.undo');
Route::resource('todos', App\Http\Controllers\TodoController::class);

Route::delete('/todos-delete-multiple', [TodoController::class, 'deleteMultiple'])->name('todos.deleteMultiple');
