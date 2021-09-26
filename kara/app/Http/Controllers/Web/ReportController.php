<?php

namespace App\Http\Controllers\Web;
use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use App\Report;
use App\User;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{

    public function postsReports()
    {
        $phone = Input::post("phone");
        $reportText = Input::post("reportText");
        $postId = Input::post("postId");
        $user = null;
        if($phone != null)
            $user = Auth::register($phone);

        $report = Report::create([
            "post_id" => $postId,
            "body" => $reportText,
            "user_id" => $user ? $user->id : null
        ]);

        $result = false;
        if($report):
            $result = true;
            Alert::html('<span class="IranBold16 fw-600 text-success">گزارش آگهی</span>','<div class="Iran14 fw-600 text-info">انتقاد شما با موفقیت ثبت شد و در صف بررسی قرار گرفت</div>','success');
        endif;    

        return response()->json($result);
    }

    public function seenReports()
    {
        $reportId = Input::post("reportId");
        $checked = Input::post("checked") == "true" ? 1 : 0;
        $report = Report::find($reportId);
        $report->is_seen = $checked;
        $report->save();
    }
}
