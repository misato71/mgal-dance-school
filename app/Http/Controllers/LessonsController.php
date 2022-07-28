<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lesson;

class LessonsController extends Controller
{
    // getでlessons/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        // メッセージ一覧を取得
        $lessons = Lesson::all();

        // メッセージ一覧ビューでそれを表示
        return view('lessons.index', [
            'lessons' => $lessons,
        ]);
    }
    // getでlessons/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $lesson = new Lesson;

        // レッスン作成ビューを表示
        return view('lessons.create', [
            'lesson' => $lesson,
        ]);
    }
    // postでlessons/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:50',
            'comment' => 'required|max:255',
        ]);

        // レッスンを登録
        $lesson = new Lesson;
        $lesson->name = $request->name;
        $lesson->comment = $request->comment;
        $lesson->save();

        // 前のURLへリダイレクト
        return redirect('lessons');
    }
}
