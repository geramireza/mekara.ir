<?php

namespace App\Http\Controllers\Mobile;

use App\Constants;
use App\Helpers\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    public function store(Request $request)
    {
        $user = Auth::register($request->post("phone"));

        $result["result"] = false;
        if ($user)
            $result["result"] = true;

        return response()->json($result);

    }

    public static function sendPassword()
    {
        $phone = Input::post("phone");
        $password = Input::post("password");
        $result["result"] = false;
        Auth::register($phone);
        if(!Session::has(Constants::KEY_EXPIRED_AT_PASSWORD) || time() > Session::get(Constants::KEY_EXPIRED_AT_PASSWORD))
        {
            Session::put(Constants::KEY_PASSWORD,$password);
            Session::put(Constants::KEY_EXPIRED_AT_PASSWORD,time() + 60 );
            $result["result"] = User::sendMessage($phone,$password);
        }
        return response()->json($result);
    }

    
    public function text()
    {
        return getPhone();
    }
}
