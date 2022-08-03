<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ReservationList;
use App\LessonSchedule;

class ReservationsController extends Controller
{
    public function index() 
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $reservation_lists = $user->reservation_lists()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'reservation_lists' => $reservation_lists,
            ];
        }
        
        // 予約一覧ビューでそれを表示
        return view('reservations.index', $data);
    }
    
    public function create($id) 
    {
        $lesson_schedule = LessonSchedule::findOrFail($id);
        $exist = '';
        // 二重予約の禁止
        foreach (\Auth::user()->reservation_lists as $reservation_list) {
            if ($reservation_list->lesson_schedule_id == $lesson_schedule->id) {
                $exist = true;
            }
        }
        
        if ($exist == true) {
            return back();
        } else {
            // 予約作成をビューで表示
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
            $lesson_schedule->reservation_limit = $lesson_schedule->reservation_limit - 1;
            $lesson_schedule->save();
            
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

        // 予約内容ビューでそれらを表示
        return view('reservations.show', [
            'reservation_list' => $reservation_list,
        ]);
    }
    
    public function update(Request $request)
    {
        // idの値で予約を検索して取得
        $reservation_list = ReservationList::findOrFail($request->reservation_list);
        
        // 予約をキャンセルのstatus=0に更新
        $reservation_list->status = 0;
        $reservation_list->save();
        
        // 予約枠、reservation_limit を+1にする
        $lesson_schedule = LessonSchedule::findOrFail($reservation_list->lesson_schedule_id);
        $lesson_schedule->reservation_limit = $lesson_schedule->reservation_limit + 1;
        $lesson_schedule->save();

        // トップページへリダイレクトさせる
        return redirect('reservations');
    }
    
    
}
