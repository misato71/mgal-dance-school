<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'name', 'comment',
    ];
    
    public function lesson_schedules()
    {
        return $this->hasMany(LessonSchedule::class);
    }

}
