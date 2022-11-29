<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lesson;

/**
* レッスンに関するコントローラークラス
* @package App\Http\Controllers
*/
class LessonsController extends Controller
{
    /**
     * レッスン一覧画面表示
     * @return レッスン一覧
     * getでlessons/にアクセスされた場合の「一覧表示処理」
     */
    public function index()
    {
        // レッスン一覧を取得
        $lessons = Lesson::all();

        // レッスン一覧ビューでそれを表示
        return view('lessons.index', [
            'lessons' => $lessons,
        ]);
    }
    /**
     * レッスン登録画面表示
     * @return 新規レッスン
     * getでlessons/createにアクセスされた場合の「新規登録画面表示処理」
     */
    public function create()
    {
        if (\Auth::user()->is_admin) {
            $lesson = new Lesson;
    
            // レッスン作成ビューを表示
            return view('lessons.create', [
                'lesson' => $lesson,
            ]);
        }
        
        return back();
    }
    /**
     * レッスン登録
     * @param レッスン登録情報
     * postでlessons/にアクセスされた場合の「新規登録処理」
     */
    public function store(Request $request)
    {
        if (\Auth::user()->is_admin) {
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
        
        return back();
    }
    
    /**
     * レッスン詳細画面表示
     * @param レッスンのid
     * @return idのレッスン詳細
     */
    public function show($id)
    {
        if (\Auth::user()->is_admin) {
             // idの値でレッスンを検索して取得
            $lesson = Lesson::findOrFail($id);
    
            // レッスン作成ビューを表示
            return view('lessons.show', [
                'lesson' => $lesson,
            ]);
        }
        
        return back();
    }
    
    /**
     * レッスン編集画面表示
     * @param レッスンのid
     * @return idのレッスン情報
     */
    public function edit($id) 
    {
       if (\Auth::user()->is_admin) {
             // idの値でレッスンを検索して取得
            $lesson = Lesson::findOrFail($id);
    
            // レッスン作成ビューを表示
            return view('lessons.edit', [
                'lesson' => $lesson,
            ]);
        }
        
        return back(); 
    }
    
    /**
     * レッスン編集
     * @param レッスンの編集情報
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->is_admin) {
            // バリデーション
            $request->validate([
                'name' => 'required|max:50',
                'comment' => 'required|max:255',
            ]);
            
            // idの値でレッスンを検索して取得
            $lesson = Lesson::findOrFail($id);
    
            // レッスンを更新
            $lesson->name = $request->name;
            $lesson->comment = $request->comment;
            $lesson->save();
    
            // 前のURLへリダイレクト
            return redirect('lessons');
        }
        
        return back();
    }
}
