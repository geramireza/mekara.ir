<?php

namespace App\Http\Controllers;

use App\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DownloadController extends Controller
{
    public function download()
    {
        $appUrl =  Constants::BASE_URL ."Kara.apk";
        return Redirect::to($appUrl);
    }

    public function getAppVersion()
    {
        $app = DB::table("apps")->get(['is_force_update AS isForceUpdate' , 'url AS appUrl','version AS lastAppVersion'])->last();
        return response()->json($app);
    }
}
