<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LessonSchedule;
use App\Models\Lesson;

/**
 * Top画面のコントローラークラス
 * @package App\Http\Controllers
 */
class ToppagesController extends Controller
{
    /**
     * Top画面
     * @return　認証済みはスケジュール一覧画面表示、それ以外はTop画面表示
     */
    public function index() {
        if(Auth::check()) {
            return redirect()->route('lesson-schedules.index');
        } else {
            return view('welcome');
        }
    }
}
