<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $fillable = [
        'title',
        'public'
    ];

    public function tasks(){
        return $this->hasMany(\App\Task::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
