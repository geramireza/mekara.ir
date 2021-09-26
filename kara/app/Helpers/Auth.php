<?php
namespace App\Helpers;

use App\User;
use App\Constants;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


#My Authorization class in this project
class Auth
{
    public static function register($phone)
    {
        $user = User::firstOrNew(["phone" =>$phone]);
        $user->save();
        return $user; # return object of user
    }
    public static function login($phone,$remember_me = false)
    {
        Session::put(Constants::KEY_PHONE,$phone);
        if ($remember_me) {
            $lifeTime = 90 * 24 * 3600;
            $rememberToken = randomToken(50);
            User::where("phone",$phone)->update(['remember_token' => $rememberToken]);
            Cookie::queue(Cookie::make(Constants::KEY_REMEMBER_TOKEN,$rememberToken,$lifeTime));
        }
    }
    public static function registerWithLogin($phone)
    {
        $user = Auth::register($phone);
        Auth::login($phone);
        return $user; # return object of user
    }

    public static function user()
    {
        $user = null;
        if(Session::has(Constants::KEY_PHONE)) :
            $user = User::where("phone",Session::get(Constants::KEY_PHONE))->first();
            $user ?: Session::forget(Constants::KEY_PHONE);
        elseif (Cookie::has(Constants::KEY_REMEMBER_TOKEN)) :
            $user = User::where("remember_token",Cookie::get(Constants::KEY_REMEMBER_TOKEN))->whereNotNull("remember_token")->first();
            $user ? Session::put(Constants::KEY_PHONE,$user->phone) : Cookie::queue(Cookie::forget(Constants::KEY_REMEMBER_TOKEN));
        endif;
        return $user; # return object of user or null
    }

    public static function userWithThisPhone($phone)
    {
        $user = null;
        if(Session::has(Constants::KEY_PHONE) && self::getPhone() == $phone) :
            $user = User::where("phone",Session::get(Constants::KEY_PHONE))->first();
        elseif (Cookie::has(Constants::KEY_REMEMBER_TOKEN)) :
            $user = User::where("remember_token",Cookie::get(Constants::KEY_REMEMBER_TOKEN))->where("phone",$phone)->whereNotNull("remember_token")->first();
            $user ? Session::put(Constants::KEY_PHONE,$user->phone) : Cookie::queue(Cookie::forget(Constants::KEY_REMEMBER_TOKEN));
        endif;
        return $user; # return object of user or null
    }
    public static function isLogin()
    {
        return Auth::user() ? true : false; # return true or false
    }
    public static function isLoginWithThisPhone($phone)
    {
        return Auth::userWithThisPhone($phone) ? true : false; # return true or false
    }

    public static function isAdmin()
    {
        $user = Auth::user();
        return $user ? $user->is_admin : false; # return 1 or 0 or false
    }

    public static function getPhone()
    {
        $user = Auth::user();
        return $user ? $user->phone : null; #return string phone or null;
    }

    public static function getUserId()
    {
        $user = Auth::user();
        return $user ? $user->id : null; #return user_id or null;
    }

    public static function logout()
    {
        Session::forget(Constants::KEY_PHONE);
        Session::forget(Constants::KEY_EXPIRED_AT_PASSWORD);
        Cookie::queue(Cookie::forget(Constants::KEY_REMEMBER_TOKEN));
    }
}