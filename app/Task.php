<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'title', 'body',
    ];

    public function taskList(){
        return $this->belongsTo(\App\TaskList::class);
    }
}
