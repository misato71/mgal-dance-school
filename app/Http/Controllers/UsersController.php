<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index() {
        $data = [];
        if (\Auth::user()->is_admin === 1){
            $users = User::all();
            $data = [
                'users' => $users,
            ];
            return view('users.index', $data);
        }
        
        return back();
    }
    
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
        if (\Auth::user()->is_admin === 1){
            $data = [
                'users' => $users, 
            ];
            return view('users.index', $data);
        }
        
        return back();
    }
    
    public function show($id) {
        $data = [];
        if (\Auth::user()->is_admin === 1){
            $user = User::findOrFail($id);
            $data = [
                'user' => $user,
            ];    
            return view('users.show', $data);
        }
        
        return back();
    }
    
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
    
    public function update(Request $request, $id) {
        // バリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'kana_name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'string', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'zipcode' => ['required', 'string', 'max:10'],
            'address' => ['required', 'string', 'max:255'],
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
