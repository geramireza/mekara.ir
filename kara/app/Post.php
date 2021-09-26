<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Sluggable;

    public $timestamps = false;
    protected $fillable = ['user_id','category_id','title','body','fee','fee_type','city','post_type','view_count','img1','img2','img3','is_enable','is_update','post_token','created_at','updated_at','is_extended','post_life','published_at','deleted_at','is_pay','is_emergency'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyAttribute($body)
    {
        return nl2br($body);
    }
}
