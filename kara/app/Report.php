<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{


    protected $fillable = [
        "user_id","post_id","report_id","body"
    ];

    public function post()
    {
        return Report::belongsTo(Post::class)->select(['id','user_id','title','slug','post_token']);
    }

    public function user()
    {
        return Report::belongsTo(User::class);
    }
}
