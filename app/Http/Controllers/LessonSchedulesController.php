<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LessonSchedule;
use App\Lesson;
use App\Instructor;
use App\Studio;

class LessonSchedulesController extends Controller
{
    public function index() 
    {
        // 本日を取得
        $today = date("Y-m-d");
        // 今月を取得
        $this_month = date('Y-m-d', strtotime('first day of this month'));
        // 今月のスケジュール一覧を取得
        $lesson_schedules = LessonSchedule::where('date', '>=', $this_month)->orderby('date')->paginate(10);
        
        // 今年を取得
        $year = date("Y");
        // 今月を取得
        $month = date("m");
        
        // 翌月を取得
        $next_month = date('Y-m-d', strtotime('first day of next month'));
        
        // スケジュール一覧ビューでそれを表示
        return view('lesson-schedules.index', [
            'lesson_schedules' => $lesson_schedules,
            'today' => $today,
            'year' => $year,
            'month' => $month,
            'next_month' => $next_month,
        ]);
    }
    
    public function next_month($next_month) {
        // 本日を取得
        $today = date("Y-m-d");
        // 翌月のスケジュール一覧を取得
        $lesson_schedules = LessonSchedule::where('date', '>=', $next_month)->orderby('date')->paginate(10);
        
        // 今年を取得
        $year = date("Y");
        // 今月を取得
        $month = date("m");
        
        // 翌月、翌年を取得
        $next = strtotime('+1 month',mktime(0, 0, 0, $month, 1, $year));
        $year = date("Y",$next);
        $month = date("m",$next);
        
        $next_month = null;
        
        // スケジュール一覧ビューでそれを表示
        return view('lesson-schedules.index', [
            'lesson_schedules' => $lesson_schedules,
            'today' => $today,
            'year' => $year,
            'month' => $month,
            'next_month' => $next_month,
        ]);
    }
    
    public function create() 
    {
        if (\Auth::user()->is_admin === 1) {
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
        
        return back();
    }
    
    public function store(Request $request)
    {
        if (\Auth::user()->is_admin === 1) {
            // バリデーション
            $request->validate([
                'date' => 'required|date',
                'start_time' => 'required|max:10',
                'finish_time' => 'required|max:10',
                'reservation_limit' => 'required|integer',
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
        
        return back();
    }
    
    public function show($id)
    {
        // idの値でスケジュールを検索して取得
        $lesson_schedule = LessonSchedule::findOrFail($id);
        // 本日を取得
        $today = date("Y-m-d");

        // スケジュール詳細ビューでそれらを表示
        return view('lesson-schedules.show', [
            'lesson_schedule' => $lesson_schedule,
            'today' => $today,
        ]);
    }
}
