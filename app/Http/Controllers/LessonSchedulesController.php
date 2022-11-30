<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LessonSchedule;
use App\Models\Lesson;
use App\Models\Instructor;
use App\Models\Studio;
use App\Models\ReservationList;

/**
* スケジュールに関するコントローラークラス
* @package App\Http\Controllers
*/
class LessonSchedulesController extends Controller
{
    /**
     * スケジュール一覧画面表示
     * @return スケジュール一覧
     */
    public function index() 
    {
        // 本日を取得
        $today = date("Y-m-d");
        // 今月初日
        $first_date = date("Y-m-d", strtotime("first day of this month"));
        // 今月末日
        $last_date = date("Y-m-d", strtotime("last day of this month"));
        // 今月のスケジュール一覧を取得
        $lesson_schedules = LessonSchedule::where('date', '>=', $first_date)->where('date', '<=', $last_date)->orderby('date')->orderby('start_time')->paginate(10);
        
        // 今年を取得
        $year = date("Y");
        // 今月を取得
        $month = date("m");
        
        // 先月を取得
        $last_month = date('Y-m', strtotime('-1 month'));
        
        // 翌月を取得
        $next_month = date('Y-m', strtotime('+1 month'));
        
        // 毎月を取得(去年の6月～来年の3月)
        $monthly = [];
        $last_year = date('Y', strtotime('-1 year'));
        $next_year = date('Y', strtotime('+1 year'));
        for ($i = 06; $i <= 12; $i++) {
            $monthly[] = $last_year . '-' .$i;
        }
        
        for ($i = 01; $i <= 12; $i++) {
            $monthly[] = $year . '-' .$i;
        }
        
        for ($i = 01; $i <= 03; $i++) {
            $monthly[] = $next_year . '-' .$i;
        }
        
        // スケジュール一覧ビューでそれを表示
        return view('lesson-schedules.index', [
            'lesson_schedules' => $lesson_schedules,
            'today' => $today,
            'year' => $year,
            'month' => $month,
            'last_month' => $last_month,
            'next_month' => $next_month,
            'monthly' => $monthly,
        ]);
    }
    
    /**
     * 日付検索
     * @param 日付
     * @return 一致した日付のスケジュール一覧
     */
    public function search(Request $request) {
        //バリデーション
        $request->validate([
            'date' => ['date'],
        ]);
        // キーワードを受け取り
        $keyword = $request->input('keyword');
        // クエリ生成
        $query = LessonSchedule::query();
        
        //もしキーワードがあったら
        if(!empty($keyword)) {
            $query->where('date','like','%'.$keyword.'%');
            // 全件取得 +ページネーション
            $lesson_schedules = $query->orderBy('start_time')->paginate(10);
        
            // 本日を取得
            $today = date("Y-m-d");
            // 今年を取得
            $year = date("Y");
            // 今月を取得
            $month = date("m");
            
            $next_month = null;
            
            $data = [
                'lesson_schedules' => $lesson_schedules,
                'today' => $today,
                'year' => $year,
                'month' => $month,
                'next_month' => $next_month,
            ];
            return view('lesson-schedules.index', $data);
        } else {
            return back();
        }
    }
    
    /**
     * 新規スケジュール作成画面表示
     * @return 新規スケジュール
     */
    public function create() 
    {
        if (\Auth::user()->is_admin) {
            $lesson_schedule = new LessonSchedule;
            $lessons = Lesson::all();
            $instructors = Instructor::all();
            $studios = Studio::all();
            
            if (!$lessons->isEmpty() && !$instructors->isEmpty() && !$studios->isEmpty()) {
                // スケジュール作成をビューで表示
                return view('lesson-schedules.create', [
                    'lesson_schedule' => $lesson_schedule,
                    'lessons' => $lessons,
                    'instructors' => $instructors,
                    'studios' => $studios,
                ]);
            } else {
                return back();
            }
            
            
        }
        
        return back();
    }
    
    /**
     * スケジュール登録
     * @param スケジュール登録情報
     */
    public function store(Request $request)
    {
        if (\Auth::user()->is_admin) {
            // バリデーション
            $request->validate([
                'lesson_id' => 'required|integer',
                'studio_id' => 'required|integer',
                'instructor_id' => 'required|integer',
                'date' => 'required|date|after:yesterday',
                'start_time' => 'required|string|max:5',
                'finish_time' => 'required|string|max:5|after:start_time',
                'reservation_limit' => 'required|integer|min:0|max:100',
            ]);
            
            //全てのスケジュールを取得
            $lesson_schedules = LessonSchedule::all();
            // スケジュール重複の確認
            foreach ($lesson_schedules as $lesson_schedule) {
                // 同日、スタジオの重複の確認
                if ($lesson_schedule->studio_id == $request->studio_id && $lesson_schedule->date == $request->date) {
                    // 時間がかぶっていないかの確認
                    if ($lesson_schedule->start_time > $request->finish_time || $lesson_schedule->finish_time < $request->start_time) {
                        
                    } else {
                        return back()->with('warning','同じ時間にスタジオが重複してます！');
                    }
                // 同日、講師の重複の確認 
                } elseif ($lesson_schedule->instructor_id == $request->instructor_id && $lesson_schedule->date == $request->date) {
                    // 時間がかぶっていないかの確認
                    if ($lesson_schedule->start_time > $request->finish_time || $lesson_schedule->finish_time < $request->start_time) {
                        
                    } else {
                        return back()->with('warning','同じ時間に講師が重複してます！');
                    }
                }
            }
                    
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
    
    /**
     * スケジュール詳細画面表示
     * @param スケジュールのid
     * @return idのスケジュール詳細
     */
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
    
    /**
     * スケジュール編集画面表示
     * @param スケジュールのid
     * @return idのスケジュール情報
     */
    public function edit($id) 
    {
        // idの値でスケジュールを検索して取得
        $lesson_schedule = LessonSchedule::findOrFail($id);
        $lessons = Lesson::all();
        $instructors = Instructor::all();
        $studios = Studio::all();
        
        if (\Auth::user()->is_admin) {
            // スケジュール編集ビューでそれらを表示
            return view('lesson-schedules.edit', [
                'lesson_schedule' => $lesson_schedule,
                'lessons' => $lessons,
                'instructors' => $instructors,
                'studios' => $studios,
            ]);
        }
        
        return back();
    }
    
     /**
     * スケジュール編集
     * @param スケジュールの編集情報
     */
    public function update(Request $request, $id) 
    {
        if (\Auth::user()->is_admin) {
            // バリデーション
            $request->validate([
                'lesson_id' => 'required|integer',
                'studio_id' => 'required|integer',
                'instructor_id' => 'required|integer',
                'date' => 'required|date|after:yesterday',
                'start_time' => 'required|string|max:5',
                'finish_time' => 'required|string|max:5|after:start_time',
                'reservation_limit' => 'required|integer|min:0|max:100',
            ]);
            
             //全てのスケジュールを取得
            $lesson_schedules = LessonSchedule::all();
            // スケジュール重複の確認
            foreach ($lesson_schedules as $lesson_schedule) {
                // 編集中のスケジュール以外で
                if ($lesson_schedule->id != $id) {
                    // 同日、スタジオの重複の確認
                    if ($lesson_schedule->studio_id == $request->studio_id && $lesson_schedule->date == $request->date) {
                        // 時間がかぶっていないかの確認
                        if ($lesson_schedule->start_time > $request->finish_time || $lesson_schedule->finish_time < $request->start_time) {
                            
                        } else {
                            return back()->with('warning','同じ時間にスタジオが重複してます！');
                        }
                    // 同日、講師の重複の確認 
                    } elseif ($lesson_schedule->instructor_id == $request->instructor_id && $lesson_schedule->date == $request->date) {
                        // 時間がかぶっていないかの確認
                        if ($lesson_schedule->start_time > $request->finish_time || $lesson_schedule->finish_time < $request->start_time) {
                            
                        } else {
                            return back()->with('warning','同じ時間に講師が重複してます！');
                        }
                    }
                } else {
                    
                } 
            }
            
            // idの値でスケジュールを検索して取得
            $lesson_schedule = LessonSchedule::findOrFail($id);
    
            // スケジュールを更新
            $lesson_schedule->lesson_id = $request->lesson_id;
            $lesson_schedule->studio_id = $request->studio_id;
            $lesson_schedule->instructor_id = $request->instructor_id;
            $lesson_schedule->date = $request->date;
            $lesson_schedule->start_time = $request->start_time;
            $lesson_schedule->finish_time = $request->finish_time;
            $lesson_schedule->reservation_limit = $request->reservation_limit;
            $lesson_schedule->save();

            return redirect('lesson-schedules');
        }
        
        return back();
    }
    
     /**
     * スケジュール削除
     * @param スケジュールのid
     */
    public function destroy($id)
    {
        // idの値でスケジュールを検索して取得
        $lesson_schedule = LessonSchedule::findOrFail($id);
        $reservation_lists = ReservationList::all();
        
        if (\Auth::user()->is_admin) {
            foreach ($reservation_lists as $reservation_list) {
                if ($lesson_schedule->id == $reservation_list->lesson_schedule_id) {
                    if ($reservation_list->status == 1) {
                        return redirect('lesson-schedules')
                        ->with('warning','予約がある為削除はできません！');
                    } elseif ($reservation_list->status == 0) {
                        // キャンセル済みの場合、スケジュールと予約リストから削除
                        $reservation_list->delete();
                        $lesson_schedule->delete();
                    }
                }
            }
            
            // スケジュールを削除
            $lesson_schedule->delete();
             
            return redirect('lesson-schedules');
        }
        
        return back();
    }
    
    /**
     * 指定月のスケジュール一覧画面表示
     * @return 指定月のスケジュール一覧
     */
    public function monthly($specified_month) {
        
         // 本日を取得
        $today = date("Y-m-d");
        
        // 月を指定
        $first_date = date('Y-m-d', strtotime('first day of ' . $specified_month));
        $last_date = date('Y-m-d', strtotime('last day of ' . $specified_month));
        
        // 翌月のスケジュール一覧を取得
        $lesson_schedules = LessonSchedule::where('date', '>=', $first_date)->where('date', '<=', $last_date)->orderby('date')->orderby('start_time')->paginate(10);
        
        // 年を取得
        $year = date("Y", strtotime($specified_month));
        
        // 月を取得
        $month = date("m", strtotime($specified_month));

        // 先月を取得
        $term = 1;
        $last_month = date('Y-m', strtotime($specified_month . " last day of -{$term} month"));
        
        // 翌月を取得
        $next_month = date('Y-m', strtotime($specified_month . '+1 month'));
        
        // 毎月を取得(去年の6月～来年の3月)
        $monthly = [];
         // 今年を取得
        $this_year = date("Y");
        $last_year = date('Y', strtotime('-1 year'));
        $next_year = date('Y', strtotime('+1 year'));
        for ($i = 06; $i <= 12; $i++) {
            $monthly[] = $last_year . '-' .$i;
        }
        
        for ($i = 01; $i <= 12; $i++) {
            $monthly[] = $this_year . '-' .$i;
        }
        
        for ($i = 01; $i <= 03; $i++) {
            $monthly[] = $next_year . '-' .$i;
        }
        
        // スケジュール一覧ビューでそれを表示
        return view('lesson-schedules.index', [
            'lesson_schedules' => $lesson_schedules,
            'today' => $today,
            'year' => $year,
            'month' => $month,
            'last_month' => $last_month,
            'next_month' => $next_month,
            'monthly' => $monthly,
        ]);
    }
    
}
