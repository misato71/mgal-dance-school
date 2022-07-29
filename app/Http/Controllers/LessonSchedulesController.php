<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LessonSchedule;
use App\Lesson;
use App\Instructor;
use App\Studio;

class LessonSchedulesController extends Controller
{
    public function index() {
        // スケジュール一覧を取得
        $lesson_schedules = LessonSchedule::all();
        $lessons = Lesson::all();
        
        // スケジュール一覧ビューでそれを表示
        return view('lesson-schedules.index', [
            'lesson_schedules' => $lesson_schedules,
            'lessons' => $lessons,
        ]);
    }
    
    public function create() {
        $lesson_schedule = new LessonSchedule;
        $lessons = Lesson::all();
        $instructors = Instructor::all();
        $studios = Studio::all();
        
        // スケジュール作成をビューで表示
        return view('lesson-schedules.create', [
            'lesson_schedule' => $lesson_schedule,
            'lessons' => $lessons,
            'instructors' => $instructors,
            'studios' => $studios,
        ]);
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'date' => 'required|max:50',
            'start_time' => 'required|max:255',
            'finish_time' => 'required|max:255',
            'reservation_limit' => 'required',
        ]);

        // スケジュールを登録
        $lesson_schedule = new LessonSchedule;
        $lesson_schedule->lesson_id = $request->lesson_id;
        $lesson_schedule->studio_id = $request->studio_id;
        $lesson_schedule->instructor_id = $request->instructor_id;
        $lesson_schedule->date = $request->date;
        $lesson_schedule->start_time = $request->start_time;
        $lesson_schedule->finish_time = $request->finish_time;
        $lesson_schedule->reservation_limit = $request->reservation_limit;
        $lesson_schedule->save();

        // 前のURLへリダイレクト
        return redirect('lesson-schedules');
    }
}