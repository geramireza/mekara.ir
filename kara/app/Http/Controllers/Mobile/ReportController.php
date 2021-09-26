<?php

namespace App\Http\Controllers\Mobile;

use App\Helpers\Auth;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    public function postsReports(Request $request)
    {
        $phone = $request->post("phone");
        $reportText = $request->post("reportText");
        $postId = $request->post("postId");
        $user = null;

        if($phone != null)
            $user = Auth::register($phone);

        $report = Report::create([
            "post_id" => $postId,
            "body" => $reportText,
            "user_id" => $user ? $user->id : null
        ]);

        $result["result"] = false;
        if($report)
            $result["result"] = true;

        return response()->json($result);
    }

}
