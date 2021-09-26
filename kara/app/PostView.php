<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    protected $fillable = ["post_id","client_ip","user_agent","app_token"];
}
