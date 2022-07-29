<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LessonSchedule;
use App\Lesson;

class ToppagesController extends Controller
{
    public function index() {
        if(Auth::check()) {
            if (Auth::user()->is_admin == 1) {
                 // スケジュール一覧を取得
                $lesson_schedules = LessonSchedule::all();
                $lessons = Lesson::all();
        
                // スケジュール一覧ビューでそれを表示
                return view('lesson-schedules.index', [
                    'lesson_schedules' => $lesson_schedules,
                    'lessons' => $lessons,
                ]);
            } elseif (Auth::user()->is_admin == 0) {
                return view('welcome');
            }
        } else {
            return view('welcome');
        }
    }
}
