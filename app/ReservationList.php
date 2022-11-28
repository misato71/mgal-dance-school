<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationList extends Model
{
    protected $fillable = [
        'lesson_schedule_id', 'user_id', 'status',
    ];
    
    public function lesson_schedule()
    {
        return $this->belongsTo(LessonSchedule::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
