<?php

namespace App\Http\Controllers\Web;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Helpers\Auth;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{

    public function create(Request $request)
    {

        $result = Auth::register($request->post("phone"));
        return response()->json(["result" => $result]);
    }

    public function login()
    {
        if(isLogin())
            return redirect()->route("myKara");

        return view("layouts.login");
    }

    public static function sendPassword()
    {
        $phone = Input::post("phone");
        Auth::register($phone);
        if(!Session::has(Constants::KEY_EXPIRED_AT_PASSWORD) || time() > Session::get(Constants::KEY_EXPIRED_AT_PASSWORD))
        {
            $password = rand(1000,9999);
            Session::put(Constants::KEY_PASSWORD,$password);
            Session::put(Constants::KEY_EXPIRED_AT_PASSWORD,time() + 60 );
            $result = User::sendMessage($phone,$password);
            return response()->json($result);
        }
        return response()->json(false);
    }

    public function confirmPhone()
    {
        $password = Input::post("password");
        $phone = Input::post("phone");
        $remember_me = Input::post("remember_me") == "true" ? true : false;
        $result = $password == Session::get(Constants::KEY_PASSWORD) ? true : false;
        if($result){
            Auth::login($phone,$remember_me);
            Alert::html('<span class="IranBold16 fw-600 text-success">ورود به حساب کاربری</span>','<div class="Iran14 fw-600 text-info">ورود شما با موفقیت انجام شد</div>','success');
        }
        return response()->json($result);
    }

    public function logout()
    {
       Auth::logout();
       return Redirect::route("home");
    }


}
