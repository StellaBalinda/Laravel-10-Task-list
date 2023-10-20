<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// home
Route::get('/', function() {
    return redirect()->route('tasks.index');
});

// list all tasks
Route::get('/tasks', function ()  {
    return view('index', ['tasks' => Task::latest()->get()
    ]);
})->name('tasks.index');

// create a task
Route::get('/tasks/create', function () {
    return view('create');
})->name('tasks.create');

// show a single task
Route::get('/tasks/{task}', function (Task $task){
    return view('show', ['task' => $task]);
})->name('tasks.show');

// edit a single task
Route::get('/tasks/{task}/edit', function (Task $task){
    return view('edit', ['task' => $task]);
})->name('tasks.edit');

// save a new post in the db
Route::post('/tasks', function (TaskRequest $request) {
    $task = Task::create($request->validated());
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task added successfully');
})->name('tasks.store');

// update: save the updated task in the db
Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    $task->update($request->validated());
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task updated successfully');
})->name('tasks.update');

// delete
Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();
    return redirect()->route('tasks.index')->with('succes', 'Task deleted Successfully');
})->name('tasks.destroy');

// Toggle Completed or not
Route::put('/tasks/{task}/toggle-complete', function (Task $task) {
    $task->toggleComplete();
    return redirect()->back()->with('success', 'Task Completed Successfully!');
})->name('tasks.toggle-complete');