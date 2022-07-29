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
        $studio = new Studio;
        
        // スタジオ作成をビューで表示
        return view('studios.create', [
            'studio' => $studio,
        ]);
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:50',
            'image' => 'max:255',
        ]);

        // スタジオを登録
        $studio = new Studio;
        $studio->name = $request->name;
        $studio->image = $request->image;
        $studio->save();

        // 前のURLへリダイレクト
        return redirect('studios');
    }
}
