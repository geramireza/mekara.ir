<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Sms;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "phone",
        "post_id_marked",
        "app_token",
        "is_verified",
        "remember_token",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public static function sendMessage($phone,$password)
    {
            $message = Constants::KEY_TEXT_MESSAGE .$password;
            $sms = new Sms(Constants::API_KEY, Constants::SECURITY_KEY,Constants::API_URL,Constants::LINE_NUMBER);
            return $sms->sendMessage([$phone],[$message]);
    }

    public static function ultraFastSend($phone,$password)
    {
        $sms = new Sms(Constants::API_KEY, Constants::SECURITY_KEY,Constants::API_URL);
        return $sms->ultraFastSend($phone,$password,Constants::PARAMETER_VERIFY_CODE,Constants::TEMPLATE_ID_VERIFY_CODE);
    }

}
