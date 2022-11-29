<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * ユーザ情報全て取得（管理者以外）
     * @return array $data ユーザ情報
     * /
    public function index() {
        $data = [];
        if (\Auth::user()->is_admin){
            // 管理者以外のユーザ全て取得
            $users = User::where('is_admin', false)->get();
            $data = [
                'users' => $users,
            ];
            return view('users.index', $data);
        }
        
        return back();
    }
    
    /**
     * ユーザ検索機能
     * @param array $request 検索条件
     * @return array $data 一致した名前又はフリガナのユーザを返す
     * /
    public function search(Request $request) {
        //バリデーション
        $request->validate([
            'name' => ['string', 'max:255'],
        ]);
        // キーワードを受け取り
        $keyword = $request->input('keyword');
        // クエリ生成
        $query = User::query();
        
         //もしキーワードがあったら
        if(!empty($keyword)) {
            $query->where('name','like','%'.$keyword.'%');
            $query->orWhere('kana_name','like','%'.$keyword.'%');
        }
        
        // 全件取得 +ページネーション
        $users = $query->orderBy('id','desc')->paginate(10);
        
        $data = [];
        if (\Auth::user()->is_admin){
            $data = [
                'users' => $users, 
            ];
            return view('users.index', $data);
        }
        
        return back();
    }
    
    /**
     * idのユーザ情報を取得
     * @param $id ユーザID
     * @return array $data idのユーザ情報を返す
     * /
    public function show($id) {
        $data = [];
        if (\Auth::user()->is_admin){
            $user = User::findOrFail($id);
            $data = [
                'user' => $user,
            ];    
            return view('users.show', $data);
        }
        
        return back();
    }
    
    /**
     * ユーザ情報編集
     * @param $id ユーザID
     * @return array $data idのユーザ情報を返す
     * /
    public function edit($id) {
        $data = [];
        $user = User::findOrFail($id);
        
        if (\Auth::id() === $user->id){
            $data = [
                'user' => $user,
            ];    
            return view('users.edit', $data);
        }
        
        return back();
    }
    
    /**
     * ユーザ情報編集内容を保存
     * @param array $request 編集内容
     * @param $id のユーザ上書き保存
     * App\Models\User
     * /
    public function update(Request $request, $id) {
        // バリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'kana_name' => ['required', 'string', 'max:100', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
            'birthday' => ['required', 'string', 'date'],
            'phone' => ['required', 'string', 'max:11', 'min:10', 'regex:/^[0-9]{10,11}$/'],
            'zipcode' => ['required', 'string', 'max:7', 'min:7', 'regex:/^[0-9]{7}$/'],
            'address' => ['required', 'string', 'max:100'],
        ]);
        
        $user = User::findOrFail($id);
        
        if (\Auth::id() === $user->id){
            $data = [];
            $user->name = $request->name;
            $user->email = $request->email;
            $user->kana_name = $request->kana_name;
            $user->birthday = $request->birthday;
            $user->phone = $request->phone;
            $user->zipcode = $request->zipcode;
            $user->address = $request->address;
            $user->save();
            
            return view('commons.complete');
        }
        
        return back();
    }
}
