<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Studio;

class StudiosController extends Controller
{
    public function index() {
        // スタジオ一覧を取得
        $studios = Studio::all();
        // スタジオ一覧ビューでそれを表示
        return view('studios.index', [
            'studios' => $studios,
        ]);
    }
    
    public function create() {
        if (\Auth::user()->is_admin === 1) {
        
            $studio = new Studio;
            
            // スタジオ作成をビューで表示
            return view('studios.create', [
                'studio' => $studio,
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

            // スタジオを登録
            $studio = new Studio;
            $studio->name = $request->name;
            $studio->image = $image;
            $studio->save();
    
            // 前のURLへリダイレクト
            return redirect('studios');
        }
        
        return back();
    }
}
