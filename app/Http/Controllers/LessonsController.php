<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lesson;

class LessonsController extends Controller
{
    // getでlessons/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        // レッスン一覧を取得
        $lessons = Lesson::all();

        // レッスン一覧ビューでそれを表示
        return view('lessons.index', [
            'lessons' => $lessons,
        ]);
    }
    // getでlessons/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        if (\Auth::user()->is_admin === 1) {
            $lesson = new Lesson;
    
            // レッスン作成ビューを表示
            return view('lessons.create', [
                'lesson' => $lesson,
            ]);
        }
        
        return back();
    }
    // postでlessons/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        if (\Auth::user()->is_admin === 1) {
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
    
    public function show($id)
    {
        if (\Auth::user()->is_admin === 1) {
             // idの値でレッスンを検索して取得
            $lesson = Lesson::findOrFail($id);
    
            // レッスン作成ビューを表示
            return view('lessons.show', [
                'lesson' => $lesson,
            ]);
        }
        
        return back();
    }
    
    public function edit($id) 
    {
       if (\Auth::user()->is_admin === 1) {
             // idの値でレッスンを検索して取得
            $lesson = Lesson::findOrFail($id);
    
            // レッスン作成ビューを表示
            return view('lessons.edit', [
                'lesson' => $lesson,
            ]);
        }
        
        return back(); 
    }
    
    public function update(Request $request, $id)
    {
        if (\Auth::user()->is_admin === 1) {
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
