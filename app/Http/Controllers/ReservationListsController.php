<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LessonSchedule;
use App\Models\ReservationList;

/**
* 管理者からの予約に関するコントローラークラス
* @package App\Http\Controllers
*/
class ReservationListsController extends Controller
{
    /**
     * 指定スケジュールの予約一覧画面表示
     * @return 指定スケジュールの予約一覧
     */
    public function table($id) 
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
             
            // 認証済みユーザを取得
            $user = \Auth::user();
            
            // 管理者用の場合
            if ($user->is_admin) {
                // スケジュールの予約を取得
                $lesson_schedule = LessonSchedule::findOrFail($id);
                
                $data = [
                    'lesson_schedule' => $lesson_schedule,
                ];
                
                return view('reservation_lists.teble', $data);
            
            }
            
            return back();
        }
        
        return back();
    }
    
    /**
     * 予約作成画面表示
     * @return 予約作成画面
     */
    public function create() 
    {
        if (\Auth::user()->is_admin) {
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
    /**
     * ユーザ検索
     * @param ユーザの名前orフリガナor電話番号
     * @return 予約新規追加画面表示
     */
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
        
            // 全件取得 +ページネーション
            $users = $query->orderBy('id','desc')->paginate(10);
            // 本日を取得
            $today = date("Y-m-d");
            
            $lesson_schedules = LessonSchedule::where('date', '>', $today)->orderby('date')->paginate(10);
            $reservation_list = new ReservationList;
            
            $data = [];
            if (\Auth::user()->is_admin){
                $data = [
                    'users' => $users,
                    'lesson_schedules' => $lesson_schedules,
                    'reservation_list' => $reservation_list,
                ];
                return view('reservation_lists.create', $data);
            } else {
                return back();
            }
        } else {
            return back();
        }
    }
    
    /**
     * 予約登録
     * @param 予約情報
     */
    public function store(Request $request)
    {
        $lesson_schedule = LessonSchedule::findOrFail($request->lesson_schedule_id);
        $user = User::findOrFail($request->user_id);
        
        if (\Auth::user()->is_admin) {
            $exist = '';
            // 二重予約の禁止
            foreach ($user->reservation_lists as $reservation_list) {
                if ($reservation_list->lesson_schedule_id == $lesson_schedule->id) {
                    if ($reservation_list->status == 1)
                    $exist = true;
                }
            }
            
            // すでに予約済みだったら、前のページへバック
            if ($exist == true) {
                return back()
                ->with('warning','すでに予約済みです！！');
            } else {
                // 予約してない場合
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
        }
        
        return back();
    }
    
    /**
     * 予約詳細画面表示
     * @param 予約のid
     * @return idの予約詳細
     */
    public function show($id)
    {
        // idの値で予約を検索して取得
        $reservation_list = ReservationList::findOrFail($id);
        
        if (\Auth::user()->is_admin) {
            // 予約内容ビューでそれらを表示
            return view('reservation_lists.show', [
                'reservation_list' => $reservation_list,
            ]);
        }
    }
    
     /**
     * 予約キャンセル
     * @param キャンセルの予約情報
     * @return 予約管理画面表示
     */
    public function update(Request $request)
    {
        // idの値で予約を検索して取得
        $reservation_list = ReservationList::findOrFail($request->reservation_list);
        
        if (\Auth::user()->is_admin) {
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
