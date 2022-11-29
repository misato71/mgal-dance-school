<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Studio;

/**
 * スタジオに関するコントローラークラス
 * @package App\Http\Controllers
 */
class StudiosController extends Controller
{
    /**
     * スタジオ一覧画面表示
     * @return スタジオ一覧
     */
    public function index() {
        // スタジオ一覧を取得
        $studios = Studio::all();
        // スタジオ一覧ビューでそれを表示
        return view('studios.index', [
            'studios' => $studios,
        ]);
    }
    
    /**
     * 新規スタジオ作成画面表示
     * @return 新規スタジオ
     */
    public function create() {
        if (\Auth::user()->is_admin) {
        
            $studio = new Studio;
            
            // スタジオ作成をビューで表示
            return view('studios.create', [
                'studio' => $studio,
            ]);
        }
        
        return back();
    }
    
    /**
     * スタジオ登録
     * @param スタジオ登録情報
     */
    public function store(Request $request)
    {
        if (\Auth::user()->is_admin) {
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
                 // S3用
                $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
                // パスから、最後の「ファイル名.拡張子」の部分だけ取得
                $image = basename($path);
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
    
    /**
     * スタジオ詳細画面表示
     * @param スタジオのid
     * @return idのスタジオ詳細
     */
    public function show($id) {
        if (\Auth::user()->is_admin) {
            // idの値でスタジオを検索して取得
            $studio = Studio::findOrFail($id);
            
            // スタジオ詳細をビューで表示
            return view('studios.show', [
                'studio' => $studio,
            ]);
        }
        
        return back();
    }
    
    /**
     * スタジオ編集画面表示
     * @param スタジオのid
     * @return idのスタジオ情報
     */
    public function edit($id) {
        if (\Auth::user()->is_admin) {
            // idの値でスタジオを検索して取得
            $studio = Studio::findOrFail($id);
            
            // スタジオ編集をビューで表示
            return view('studios.edit', [
                'studio' => $studio,
            ]);
        }
        
        return back();
    }
    
    /**
     * スタジオ編集
     * @param スタジオの編集情報
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->is_admin) {
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
                // S3用
                $path = Storage::disk('s3')->putFile('/uploads', $file, 'public');
                // パスから、最後の「ファイル名.拡張子」の部分だけ取得
                $image = basename($path);
            
            }else{
                // 画像が選択されていなければ空文字をセット
                $image = '';
            }

            // idの値でスタジオを検索して取得
            $studio = Studio::findOrFail($id);
            
            // スタジオを更新
            $studio->name = $request->name;
            $studio->image = $image;
            $studio->save();
    
            // 前のURLへリダイレクト
            return redirect('studios');
        }
        
        return back();
    }
}
