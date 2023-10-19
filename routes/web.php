<?php

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
Route::get('/tasks/{id}', function ($id){
    return view('show', ['task' => Task::findOrFail($id)]);
})->name('tasks.show');

// edit a single task
Route::get('/tasks/{id}/edit', function ($id){
    return view('edit', ['task' => Task::findOrFail($id)]);
})->name('tasks.edit');

// save a new post in the db
Route::post('/tasks', function (Request $request) {
    $data = $request->validate([
        'title' => 'required | max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]);
    $task = new Task;
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];

    $task->save();

    return redirect()->route('tasks.show', ['id' => $task->id])->with('success', 'Task added successfully');

})->name('tasks.store');

// update: save the updated task in the db
Route::put('/tasks/{id}', function ($id, Request $request) {
    $data = $request->validate([
        'title' => 'required | max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]);
    $task = Task::findOrFail($id);
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];

    $task->save();

    return redirect()->route('tasks.show', ['id' => $task->id])->with('success', 'Task updated successfully');

})->name('tasks.update');
