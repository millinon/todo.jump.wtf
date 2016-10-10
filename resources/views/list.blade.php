@extends('layouts.app')

@section('content')

<div class="container">
    @if (Auth::guest() || Auth::user()->id !== $list->user->id)
        <h1>{{ $list->user->name }}'s list</h1><br />
    @endif
    
    <h1>{{ $list->title }}</h1>

    <!-- todo: change to XHR -->

    @if (! Auth::guest() && Auth::user()->id == $list->user->id)
        <form action="/togglePublic/{{$list->id}}" method="POST">
        {{ method_field('POST') }}
        {{ csrf_field() }}
        @if ($list->public == 1)
        <input name="public-toggle" type="checkbox" checked data-toggle="toggle" data-on="Public" data-off="Private" onChange="this.form.submit()" />
        @else
        <input name="public-toggle" type="checkbox"         data-toggle="toggle" data-on="Public" data-off="Private" onChange="this.form.submit()"/>
        @endif
        </form>

        <br />

    @endif


    @if ($list->tasks()->count() == 0)
        <h2>This list is empty.</h2>
    @else    
        <div class="list-group">
            @foreach ($list->tasks as $task)
                @if ($task->complete)
                    <div class="list-group-item list-group-item-success clearfix">
                @else
                    <div class="list-group-item clearfix">
                @endif    
                    @if (!Auth::guest() && Auth::user()->id == $list->user->id)
                    <div class="pull-right">
                        <form action="/task/{{$task->id}}/toggle" method="POST">
                            {{ method_field('POST') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">
                                @if (! $task->complete)
                                    <span class="glyphicon glyphicon-ok"></span>
                                @else
                                    <span class="glyphicon glyphicon-remove"></span>
                                @endif
                            </button>
                        </form>

                        <br />

                        <form action="/task/{{$task->id}}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </form>
                    </div>
                    @endif
                    <h4>{{$task->title}}</h4>
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

    @if (count($errors) > 0)
        <br />
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
</div>
@stop
