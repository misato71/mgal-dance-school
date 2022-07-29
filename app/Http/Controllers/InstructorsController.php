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
        $instructor = new Instructor;
        
        // 講師作成をビューで表示
        return view('instructors.create', [
            'instructor' => $instructor,
        ]);
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:50',
            'comment' => 'required|max:255',
            'image' => 'max:255',
        ]);

        // 講師を登録
        $instructor = new Instructor;
        $instructor->name = $request->name;
        $instructor->comment = $request->comment;
        $instructor->image = $request->image;
        $instructor->save();

        // 前のURLへリダイレクト
        return redirect('instructors');
    }
}
