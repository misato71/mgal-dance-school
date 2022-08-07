<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Instructor;

class InstructorsController extends Controller
{
    public function index() {
        // 講師一覧を取得
        $instructors = Instructor::all();
        // 講師一覧ビューでそれを表示
        return view('instructors.index', [
            'instructors' => $instructors,
        ]);
    }
    
    public function create() {
        if (\Auth::user()->is_admin === 1) {
            $instructor = new Instructor;
            
            // 講師作成をビューで表示
            return view('instructors.create', [
                'instructor' => $instructor,
            ]);
        }
        
        return back();
    }
    
    public function store(Request $request)
    {
        if (\Auth::user()->is_admin === 1) {
            // バリデーション
            $request->validate([
                'name' => 'required|max:50',
                'comment' => 'required|max:255',
                'image' => [
                    'file',
                    'mimes:jpeg,jpg,png,JPG'
                ],
            ]);
            
            // 入力情報の取得
            $file =  $request->image;
            
            // 画像のアップロード
            if($file){
                // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名作成
                $image = time() . $file->getClientOriginalName();
                // アップロードするフォルダ名取得
                $target_path = public_path('uploads/');
                // アップロード処理
                $file->move($target_path, $image);
            }else{
                // 画像が選択されていなければ空文字をセット
                $image = '';
            }
        
            // 講師を登録
            $instructor = new Instructor;
            $instructor->name = $request->name;
            $instructor->comment = $request->comment;
            $instructor->image = $image;
            $instructor->save();
    
            // 前のURLへリダイレクト
            return redirect('instructors');
        }
        
        return back();
    }
    
    public function show($id) {
        if (\Auth::user()->is_admin === 1) {
            // idの値で講師を検索して取得
            $instructor = Instructor::findOrFail($id);
            
            // 講師作成をビューで表示
            return view('instructors.show', [
                'instructor' => $instructor,
            ]);
        }
        
        return back();
    }
    
    public function edit($id) {
        if (\Auth::user()->is_admin === 1) {
            // idの値で講師を検索して取得
            $instructor = Instructor::findOrFail($id);
            
            // 講師作成をビューで表示
            return view('instructors.edit', [
                'instructor' => $instructor,
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
                'image' => [
                    'file',
                    'mimes:jpeg,jpg,png,JPG'
                ],
            ]);
            
            // 入力情報の取得
            $file =  $request->image;
            
            // 画像のアップロード
            if($file){
                // 現在時刻ともともとのファイル名を組み合わせてランダムなファイル名作成
                $image = time() . $file->getClientOriginalName();
                // アップロードするフォルダ名取得
                $target_path = public_path('uploads/');
                // アップロード処理
                $file->move($target_path, $image);
            }else{
                // 画像が選択されていなければ空文字をセット
                $image = '';
            }
            
            // idの値で講師を検索して取得
            $instructor = Instructor::findOrFail($id);
        
            // 講師を更新
            $instructor->name = $request->name;
            $instructor->comment = $request->comment;
            $instructor->image = $image;
            $instructor->save();
    
            // 前のURLへリダイレクト
            return redirect('instructors');
        }
        
        return back();
    }
}
