<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;


class ChangePasswordController extends Controller
{
    public function edit()
    {
        return view('password.edit');
    }

    protected function validator(array $data)
    {
        return Validator::make($data,[
            'new_password' => 'required|string|min:8|confirmed',
            ]);
    }
    
    public function update(Request $request)
    {
        $user = \Auth::user();
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
