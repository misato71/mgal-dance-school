<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ReservationList;
use App\Models\LessonSchedule;

class ReservationsController extends Controller
{
    public function index() 
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // 本日を取得
                $today = date('Y-m-d');
            // 管理者用予約一覧を取得
            if ($user->is_admin) {
                // 本日からの予約を取得
                $lesson_schedules = LessonSchedule::where('date', '>=', $today)->orderby('date')->orderBy('start_time')->paginate(1);
                
                $data = [
                    'lesson_schedules' => $lesson_schedules,
                ];
                return view('reservation_lists.index', $data);
            
            //ユーザの予約一覧を取得
            } else {
                // ユーザの投稿の一覧を作成日時の降順で取得
                $reservation_lists = $user->reservation_lists()->orderBy('created_at', 'desc')->paginate(10);
                
                $data = [
                    'reservation_lists' => $reservation_lists,
                    'today' => $today,
                ];
                
                // 予約一覧ビューでそれを表示
                return view('reservations.index', $data);
            }
            
        }
        
    }
    
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
            $lesson_schedules = $query->orderBy('id','desc')->paginate(1);
            
            if (\Auth::user()->is_admin){
                $data = [
                        'lesson_schedules' => $lesson_schedules,
                ];
                return view('reservation_lists.index', $data);
            } else {
                return back();
            }
        } else {
            return back();
        }
    }
    
    public function create($id) 
    {
        $lesson_schedule = LessonSchedule::findOrFail($id);
        
        $exist = '';
        // 二重予約の禁止
        foreach (\Auth::user()->reservation_lists as $reservation_list) {
            if ($reservation_list->lesson_schedule_id == $lesson_schedule->id) {
                if ($reservation_list->status == 1)
                $exist = true;
            }
        }
        // すでに予約済みだったら、前のページへバック
        if ($exist == true) {
            return back();
        } else {
            // 予約してない場合は、予約作成をビューで表示
            return view('reservations.create', [
                'lesson_schedule' => $lesson_schedule,
            ]);
        }
    }
    
    
    public function store(Request $request)
    {
        $lesson_schedule = LessonSchedule::findOrFail($request->lesson_schedule_id);
        
        // 予約枠、reservation_limit = 1、又は1以上は予約ができる
        if ($lesson_schedule->reservation_limit >= 1) {
            $request->user()->reservation_lists()->create([
                'lesson_schedule_id' => $request->lesson_schedule_id,
                'user_id' => $request->user()->id,
                'status' => 1,
            ]);
            // 予約一覧のURLへリダイレクト
            return redirect('reservations');
            
        // 予約枠、reservation_limit = 0、又は0以下は予約はできないようにする
        } elseif ($lesson_schedule->reservation_limit <= 0) {
            return back();
        }
        
    }
    
     public function show($id)
    {
        // idの値で予約を検索して取得
        $reservation_list = ReservationList::findOrFail($id);
        
        if ($reservation_list->user_id == \Auth::id()){
            // 予約内容ビューでそれらを表示
            return view('reservations.show', [
                'reservation_list' => $reservation_list,
            ]);
        }
    }
    
    public function update(Request $request)
    {
        // idの値で予約を検索して取得
        $reservation_list = ReservationList::findOrFail($request->reservation_list);
        
        if (\Auth::id() === $reservation_list->user_id) {
            // 予約をキャンセルのstatus=0に更新
            $reservation_list->status = 0;
            $reservation_list->save();
    
            // トップページへリダイレクトさせる
            return redirect('reservations');
        }
        
        return back();
    }
    
    
}
