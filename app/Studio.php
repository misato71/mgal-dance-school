<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = [
        'name', 'image',
    ];
    
    public function lesson_schedules()
    {
        return $this->hasMany(LessonSchedule::class);
    }
}
