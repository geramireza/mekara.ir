<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = ["post_id","user_id","amount","status","gate","transaction_id","reference_id","is_emergency","post_life","is_extended","is_ladder"];
}
