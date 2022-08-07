<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LessonSchedule;
use App\ReservationList;

class ReservationListsController extends Controller
{
    public function create() 
    {
        if (\Auth::user()->is_admin === 1) {
            $users = [];
            $lesson_schedules = [];
            $reservation_list = new ReservationList;
            // 予約作成をビューで表示
            return view('reservation_lists.create', [
                'users' => $users,
                'lesson_schedules' => $lesson_schedules,
                'reservation_list' => $reservation_list,
            ]);
        }
        
        return back();
    }
    
    public function search(Request $request) {
        // キーワードを受け取り
        $keyword = $request->input('keyword');
        // クエリ生成
        $query = User::query();
        
         //もしキーワードがあったら
        if(!empty($keyword)) {
            $query->where('name','like','%'.$keyword.'%');
            $query->orWhere('kana_name','like','%'.$keyword.'%');
            $query->orWhere('phone','like','%'.$keyword.'%');
        }
        
        // 全件取得 +ページネーション
        $users = $query->orderBy('id','desc')->paginate(10);
        // 本日を取得
        $today = date("Y-m-d");
        
        $lesson_schedules = LessonSchedule::where('date', '>', $today)->orderby('date')->paginate(10);
        $reservation_list = new ReservationList;
        
        $data = [];
        if (\Auth::user()->is_admin === 1){
            $data = [
                'users' => $users,
                'lesson_schedules' => $lesson_schedules,
                'reservation_list' => $reservation_list,
            ];
            return view('reservation_lists.create', $data);
        }
        
        return back();
    }
    
    public function store(Request $request)
    {
        $lesson_schedule = LessonSchedule::findOrFail($request->lesson_schedule_id);
        
        if (\Auth::user()->is_admin === 1) {
        
            // 予約枠、reservation_limit = 1、又は1以上は予約ができる
            if ($lesson_schedule->reservation_limit >= 1) {
                $lesson_schedule->reservation_limit = $lesson_schedule->reservation_limit - 1;
                $lesson_schedule->save();
                
                $reservation_list = new ReservationList;
                $reservation_list->lesson_schedule_id = $request->lesson_schedule_id;
                $reservation_list->user_id = $request->user_id;
                $reservation_list->status = 1;
                $reservation_list->save();
                
                // 予約一覧のURLへリダイレクト
                return redirect('reservations');
                
            // 予約枠、reservation_limit = 0、又は0以下は予約はできないようにする
            } elseif ($lesson_schedule->reservation_limit <= 0) {
                return back();
            }
        }
        
        return back();
    }
    
    public function show($id)
    {
        // idの値で予約を検索して取得
        $reservation_list = ReservationList::findOrFail($id);
        
        if (\Auth::user()->is_admin === 1) {
            // 予約内容ビューでそれらを表示
            return view('reservation_lists.show', [
                'reservation_list' => $reservation_list,
            ]);
        }
    }
    
    public function update(Request $request)
    {
        // idの値で予約を検索して取得
        $reservation_list = ReservationList::findOrFail($request->reservation_list);
        
        if (\Auth::user()->is_admin === 1) {
            // 予約をキャンセルのstatus=0に更新
            $reservation_list->status = 0;
            $reservation_list->save();
            
            // 予約枠、reservation_limit を+1にする
            $lesson_schedule = LessonSchedule::findOrFail($reservation_list->lesson_schedule_id);
            $lesson_schedule->reservation_limit = $lesson_schedule->reservation_limit + 1;
            $lesson_schedule->save();
    
            // 予約管理へリダイレクトさせる
            return redirect('reservations');
        }
        
        return back();
    }
}
