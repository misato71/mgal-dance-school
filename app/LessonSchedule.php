<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonSchedule extends Model
{
    protected $fillable = [
        'lesson_id', 'studio_id', 'instructor_id', 'date', 'start_time', 'finish_time', 'reservation_limit',
    ];
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    
    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
    
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
    
    public function reservation_lists()
    {
        return $this->hasMany(ReservationList::class);
    }
    
}
