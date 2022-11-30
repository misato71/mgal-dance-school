<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * スタジオテーブルのモデルクラス
 * @package App\Models
 */
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
