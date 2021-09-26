<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Post;
use App\PostView;
use App\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Sms;

class TestController extends Controller
{

    public function sendLink(Request $request)
    {
        return $_SERVER;
    }
}
