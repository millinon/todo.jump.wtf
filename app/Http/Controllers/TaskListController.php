<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;
use App\TaskList;
use App\User;

use Auth;
use Redirect;

class TaskListController extends Controller
{
    public function showList(TaskList $list){
        if(Auth::id() == $list->user->id || ($list->public == 1)){
            return view('list', compact('list'));
        }

        return view('errors.403');

    }

    public function showUserLists(User $user){
        return view('userLists', compact('user'));
    }

    public function makeList(Request $request){
        $this->validate($request, [
            'title' => 'required'
        ]);

        $list = new TaskList();
        $list->title = $request->title;
        $list->user_id = Auth::id();
        $list->public = isset($request->public) && $request->public == '1';
        $list->save();

        return Redirect::back();

    }

    public function addItem(Request $request, TaskList $list){
        $this->validate($request, [
            'title' => ['required', 'max:63']
        ]);

        if(Auth::guest() || Auth::user()->id !== $list->user->id){
            return 'get outta here';
        }

        $task = new Task();

        $task->title = $request->title;
        $task->body = empty($request->body) ? '' : $request->body;
        $task->complete = false;
        $task->task_list_id = $list->id;
        $task->save();

        return Redirect::back();
    }

    public function delList(TaskList $list){
        if(Auth::guest() || Auth::id() != $list->user->id){
            return 'get outta here';
        }

        $list->delete();

        return Redirect::back();
    }

    public function togglePublic(Tasklist $list){
        if(Auth::guest() || Auth::id() != $list->user->id){
            return 'get outta here';
        }

        $list->public = !$list->public;
        $list->save();

        return Redirect::back();
    }
}
