<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;
use App\TaskList;

use Auth;
use Redirect;

class TaskController extends Controller
{

    public function delItem(Task $task){

        if(Auth::guest() || Auth::id() != $task->taskList->user->id){
            return 'get outta here';
        }

        $task->delete();

        return Redirect::back();
    }
}
