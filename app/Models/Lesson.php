<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * レッスンテーブルのモデルクラス
 * @package App\Models
 */
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
