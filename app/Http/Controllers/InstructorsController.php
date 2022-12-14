<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Instructor;

/**
* 講師に関するコントローラークラス
* @package App\Http\Controllers
*/
class InstructorsController extends Controller
{
    /**
     * 講師一覧画面表示
     * @return 講師一覧
     */
    public function index() {
        // 講師一覧を取得
        $instructors = Instructor::all();
        // 講師一覧ビューでそれを表示
        return view('instructors.index', [
            'instructors' => $instructors,
        ]);
    }
    
    /**
     * 新規講師作成画面表示
     * @return 新規講師
     */
    public function create() {
        if (\Auth::user()->is_admin) {
            $instructor = new Instructor;
            
            // 講師作成をビューで表示
            return view('instructors.create', [
                'instructor' => $instructor,
            ]);
        }
        
        return back();
    }
    
    /**
     * 講師登録
     * @param 講師登録情報
     */
    public function store(Request $request)
    {
        if (\Auth::user()->is_admin) {
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
                // S3用
                $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
                // パスから、最後の「ファイル名.拡張子」の部分だけ取得
                $image = basename($path);
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
    
    /**
     * 講師詳細画面表示
     * @param 講師のid
     * @return idの講師詳細
     */
    public function show($id) {
        if (\Auth::user()->is_admin) {
            // idの値で講師を検索して取得
            $instructor = Instructor::findOrFail($id);
            
            // 講師作成をビューで表示
            return view('instructors.show', [
                'instructor' => $instructor,
            ]);
        }
        
        return back();
    }
    
    /**
     * 講師編集画面表示
     * @param 講師のid
     * @return idの講師情報
     */
    public function edit($id) {
        if (\Auth::user()->is_admin) {
            // idの値で講師を検索して取得
            $instructor = Instructor::findOrFail($id);
            
            // 講師作成をビューで表示
            return view('instructors.edit', [
                'instructor' => $instructor,
            ]);
        }
        
        return back();
    }
    
    /**
     * 講師編集
     * @param 講師の編集情報
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->is_admin) {
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
                // S3用
                $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
                // パスから、最後の「ファイル名.拡張子」の部分だけ取得
                $image = basename($path);
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
