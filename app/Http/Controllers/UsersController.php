<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;

class UsersController extends Controller
{
    public function __contruct(){
        $this->middleware("auth");
    }

    public function changePassword()
    {
        return view('auth.change_password');
    }

    public function getUser()
    {
        return response()->json(array(
            'ao' => auth()->user()->ao,
            'id'=> auth()->user()->FEMPIDNO 
        ));
    }

    public function updatePassword()
    {
        $old     = request()->get('old_password');
        $new     = request()->get('new_password');
        $confirm = request()->get('confirm_password');

            if (!Hash::check($old, auth()->user()->password))
            {
                return response()->json(array(
                            'code'      =>  400,
                            'message'   =>  "Password given incorrect"
                        ), 400);
            }

            if($new !== $confirm)
            {
            return response()->json(array(
                            'code'      =>  401,
                            'message'   =>  "New password not matched"
                        ), 401);
            }

            $user = auth()->user()->findOrFail( auth()->user()->id);
            $user->password = bcrypt($new);
            $user->save();

            return $user;
    }
}
