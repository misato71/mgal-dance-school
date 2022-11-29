<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

/**
* パスワード変更に関するコントローラークラス
* @package App\Http\Controllers
*/
class ChangePasswordController extends Controller
{
    /**
     * パスワード変更画面表示
     * @return パスワード変更画面
     */
    public function edit()
    {
        return view('password.edit');
    }

    /**
     * 新しいパスワードのバリデーション
     */
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'new_password' => 'required|string|min:8|confirmed',
            ]);
    }
    
    /**
     * パスワード変更
     * @param パスワード変更情報
     * @return パスワード変更完了画面
     */
    public function update(Request $request)
    {
        $user = \Auth::user();
        
        //以前のパスワード確認
        if(!password_verify($request->current_password,$user->password))
        {
            return redirect('/password/change')
                ->with('warning','以前のPasswordは必須です。');
        }

        //新規パスワードの確認
        $this->validator($request->all())->validate();

        $user->password = bcrypt($request->new_password);
        $user->save();

        return view ('commons.complete');
    }
}
