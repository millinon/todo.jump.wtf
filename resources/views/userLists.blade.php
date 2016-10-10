@extends('layouts.app')

@section('title', 'Your Lists')

@section('content')
<div class="container">
    <h1>Your to-do lists:</h1>

    @if (Auth::user()->lists()->count() == 0)
        <h2>You don't have any to-do lists.</h2>
    @else
        <div class="list-group">
            @foreach (Auth::user()->lists as $list)
                    <!--<div class="list-group-item list-group-item-action">-->
                        <a class="list-group-item list-group-item-action" href="/list/{{$list->id}}">
                    <div class="pull-right">
                        <form action="/list/{{$list->id}}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </form>
                    <!--</div>-->
                    </div>
                    <h4>{{ $list->title }}</h4>
                    </a>
            @endforeach
        </div>
    @endif

    <hr />

    <h1>Create a new to-do list:</h1>

    <form method="POST" action="/list">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">List Title:</label>
            <input name="title" type="text" />
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="public" />
                Public to-do list
            </label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>

    @if (count($errors) > 0)
        <br />
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

@stop
