@extends('layouts.app')

@section('title', 'The list of tasks')
    
@section('content')
    <div>
        <a href="{{ route('tasks.create') }}">Add a New Task</a>
    </div> <br>
    @forelse ($tasks as $task)
    <div>
        <a href="{{route('tasks.show', ['task' => $task->id])}}">{{$task->title}}</a>
    </div>
    @empty
        <p>No task available</p>
    @endforelse

@endsection