<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 講師テーブルのモデルクラス
 * @package App\Models
 */
class Instructor extends Model
{
    protected $fillable = [
        'name', 'comment', 'image',
    ];
    
    public function lesson_schedules()
    {
        return $this->hasMany(LessonSchedule::class);
    }
}
