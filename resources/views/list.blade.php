@extends('layouts.app');

@section('content')

<div class="container">
    @if (Auth::guest() || Auth::user()->id !== $list->user->id)
        <h1>{{ $list->user->name }}'s list</h1><br />
    @endif
    <h1>{{ $list->title }}</h1>

    @if ($list->tasks()->count() == 0)
        <h2>This list is empty.</h2>
    @else    
        <div class="list-group">
            @foreach ($list->tasks as $task)
                <div class="list-group-item">
                    <h4>{{$task->title}}</h4>
                    @if (!Auth::guest() && Auth::user()->id == $list->user->id)
                    <div class="text-right">
                        <form action="/task/{{$task->id}}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </form>
                    </div>
                    @endif
                    <h5>{{$task->body}}</h5>
                </div>
            @endforeach
        </div>
    @endif

    <hr />

    @if (!Auth::guest() && Auth::user()->id == $list->user->id)
        <h1>Add an item:</h1>

        <form method="POST" action="/list/{{$list->id}}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="row">
                <div class="form-group col-lg-5">
                    <label for="title">Title:</label>
                    <input name="title" class="form-control" type="text" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-5">
                    <label for="body">Description:</label>
                    <textarea class="form-control" name="body" placeholder="(Optional)"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    @endif
    
</div>
@stop
