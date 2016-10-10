<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => ['web']], function(){

    Auth::routes();
    
    Route::get('/', function () {
        return view('welcome');
    });
    

//    Route::get('/home', 'HomeController@index')->middleware('auth');


    // show the items on a list
    Route::get('/list/{list}', 'TaskListController@showList');

    Route::group(['middleware' => 'auth'], function(){
        
        Route::get('/home', 'TaskListController@showUserLists');

        // show the lists
        Route::get('/lists', 'TaskListController@showUserLists');
        // create a new list
        Route::put('/list', 'TaskListController@makeList');
        // remove a list
        Route::delete('/list/{list}', 'TaskListController@delList');
        
        // add on to a list
        Route::put('/list/{list}', 'TaskListController@addItem');
        // delete from a list
        Route::delete('/task/{task}', 'TaskController@delItem');

        Route::post('/togglePublic/{list}', 'TaskListController@togglePublic');

        Route::post('/task/{task}/toggle', 'TaskController@toggleCompletion');

    });

});
