<?php

use App\Helpers\Auth;


function isAdmin()
{
   return Auth::isAdmin();
}
function isLogin()
{
   return Auth::isLogin();
}
function isLoginWithThisPhone($phone)
{
    return Auth::isLoginWithThisPhone($phone);
}
function userWithThisPhone($phone)
{
    return Auth::userWithThisPhone($phone);
}
function user()
{
   return Auth::user();
}
function register($phone)
{
   return Auth::register($phone);
}
function login($phone)
{
   return Auth::login($phone);
}

function registerWithLogin($phone)
{
   return Auth::registerWithLogin($phone);
}

function getPhone()
{
   return Auth::getPhone();
}
function getUserId()
{
    return Auth::getUserId();
}
function logout()
{
   return Auth::logout();     
}

function getArrayImages($images){
    $imagesArray = [];
    foreach ($images as $image):
        if($image)
            array_push($imagesArray,$image);
    endforeach;    
    return $imagesArray;
}
function getArrayImageNames($images)
{
    $imageNames = [];
    foreach ($images as $image):
        if($image):
            $urlParts = explode("/",$image);
            if ($urlParts)
            array_push($imageNames,end($urlParts));
        endif;
    endforeach;
    return $imageNames;

}

function getImageName($image)
{
    $imageName = null;
        if($image):
            $urlParts = explode("/",$image);
            if ($urlParts)
                $imageName = end($urlParts);
        endif;
    return $imageName;
}
function convert($string)
{
        $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $latin_num = range(0, 9);
        $string = str_replace($latin_num, $persian_num, $string);
        return $string;
}

function convert2En($string)
{
    $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $latin_num = range(0, 9);
    $string = str_replace($persian_num, $latin_num, $string);
    return $string;
}

function randomToken($length){
        $string = '';
        while($len = strlen($string) < $length) :
                $size = $length - $len;
                $bytes = random_bytes($size);
                $string .= substr(str_replace(['/','*','<','$','.','#','@','!','%','^','&','(',')','~',':',';'],'',bcrypt($bytes)),0,$size);
        endwhile;
        return $string;
}

function getTimeAgo ($time)
{
        $time = time() - strtotime($time);
        $tokens = array (
            31536000 => 'سال',
            2592000 => 'ماه',
            604800 => 'هفته',
            86400 => 'روز',
            3600 => 'ساعت',
            60 => 'دقیقه',
            1 => 'ثانیه'
        );
        foreach ($tokens as $unit => $text) :
                if ($time < $unit) continue;
                        $numberOfUnits = floor($time / $unit);
                if($unit == 1 || ($unit == 60 && $numberOfUnits < 15))
                        $txt = "دقایقی پیش";
                elseif ($unit == 60 && $numberOfUnits < 30 )
                        $txt = "یک ربع پیش";
                elseif ($unit == 60 && $numberOfUnits < 60 )
                        $txt = "نیم ساعت پیش";
                elseif ($unit == 86400 && $numberOfUnits < 2 )
                        $txt = "دیروز";
                elseif ($unit == 86400 && $numberOfUnits < 3 )
                        $txt = "پریروز";
                else
                        $txt = $numberOfUnits;
                return $txt != $numberOfUnits ? $txt : convert($numberOfUnits) . ' ' . $text . ' پیش';
        endforeach;
}

function numberFormat($str, $sep = ',')
{
    $result = '';
    $c = 0;
    $num = strlen($str);
    for ($i = $num - 1; $i >= 0; $i--) {
        if ($c == 3) {
            $result = $sep . $result;
            $result = $str[$i] . $result;
            $c = 0;
        } else {
            $result = $str[$i] . $result;
        }

        $c++;
    }
    return $result;
}

function toString($param)
{
    return $param."";
}
