<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['user_id','body'];

    public function user()
    {
        return Contact::belongsTo(User::class);
    }
    
    
}
