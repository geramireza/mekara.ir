<?php

namespace App\Http\Controllers\Payment;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use SoapClient;


class WebPaymentController extends Controller
{
    public function paymentRequest(Request $request)
    {
        $post = $this->getPostParams($request);
        $amount = $post->price;
        $description = Constants::STR_PAY_DESCRIPTION;
        $mobile = getPhone();
        $data = [
            'MerchantID' =>Constants::ZARINPAL_MERCHANT_ID,
            'Amount' => $amount,
            'Description' => $description,
            'Mobile' =>$mobile,
            'CallbackURL' =>Constants::ZARINPAL_CALLBACK_URL .$post->id
        ];

        if ($amount != 0)
        {
            $client = new SoapClient(Constants::ZARINPAL_PURCHASE_URL,["encoding" => "UTF-8"]);
            $result = $client->paymentRequest($data);
            if ($result->Status == 100){
                \App\Payment::create([
                    "post_id" => $post->id,
                    "user_id" => getUserId(),
                    "amount"  => $amount,
                    "post_life" => $post->post_life,
                    "is_emergency" => $post->is_emergency,
                    "is_extended" => $post->is_extended,
                    "is_ladder" => $request->has("ladder") ? 1 : 0,
                    "gate" => "zarinpalWeb",
                    "transaction_id" => $result->Authority
                ]);
                Header('Location:' . Constants::ZARINPAL_PAYMENT_URL . $result->Authority);
                exit(); // this is important;
            }
            else
                $status = $result->Status;
        }else
        {
            $this->setAlert(0);
            return back();
        }


    }

    public function paymentVerify(Request $request)
    {
        $postId = $request->postId;
        $authority = $request->Authority;
        $status = $request->Status;
        $post = Post::find($postId);
        $payment = \App\Payment::where("post_id",$postId)->where("transaction_id",$authority)->get()->last();
        $data = [
            'MerchantID' =>Constants::ZARINPAL_MERCHANT_ID,
            'Amount' => $payment->amount,
            'Authority' =>$authority
        ];

        if ($status == "OK")
        {
            $client = new SoapClient(Constants::ZARINPAL_PURCHASE_URL,["encoding" => "UTF-8"]);
            $result = $client->paymentVerification($data);
            if ($result->Status == 100)
            {
                $payment->update([
                    "status" => 1,
                    "reference_id" => $result->RefID
                ]);
                $this->setChangePost($payment);
            }
            $status = $result->Status;

        }else
            $status = -2;
            $this->setAlert($status);
            return redirect()->route("manage",["param" => "pay","token" => $post->post_token]);
    }

    private function setChangePost($payment)
    {
        $post = Post::find($payment->post_id);
        $post->is_emergency = $payment->is_emergency;
        $post->post_life = $payment->post_life;
        $post->is_extended = $payment->is_extended;
        $post->is_pay = 1;
        $post->updated_at = Carbon::now();
        if ($payment->is_ladder)
            $post->published_at = Carbon::now();
        $post->save();
    }

    public function getPostParams($request)
    {
        $price = 0;
        $post = Post::where("post_token", $request->post_token)->first();
        $prices = $this->getPrices();
        if(isset($request->post_type))
        {
            if($request->pay_type == Constants::KEY_MONTHLY)
            {
                $price += $prices->monthly;
                $post->post_life = 30;
            }
            elseif($request->pay_type == Constants::KEY_WEEKLY)
            {
                $price += $prices->weekly;
                $post->post_life = 7;
            }
            elseif($request->pay_type == Constants::KEY_MONTHLY_KARJOO)
            {
                $price += $prices->monthlyKarjoo;
                $post->post_life = 30;
            }
            elseif($request->pay_type == Constants::KEY_WEEKLY_KARJOO)
            {
                $price += $prices->weeklyKarjoo;
                $post->post_life = 7;
            }
        }

        if(isset($request->emergency))
        {
            $price += $prices->emergency;
            $post->is_emergency = 1;
        }

        if(isset($request->extended))
            {
                $price += $prices->extended;
                $post->is_extended = 1;
            }


        if(isset($request->ladder))
            {
                $price += $prices->ladder;
                $post->published_at = Carbon::now();
                $post->updated_at = Carbon::now();
            }
        $post->price = $price;
        return $post;
    }

    public function getPrices()
    {
        return DB::table("post_publish_prices")->latest()->first(["monthly","monthly_karjoo AS monthlyKarjoo","weekly","weekly_karjoo AS weeklyKarjoo","emergency","extended","ladder"]);
    }

    public function setAlert($status)
    {
        switch ($status)
        {
            case 100 :
                $message = "عملیات پرداخت با موفقیت انجام شد و آگهی جهت بررسی در صف تایید قرار گرفت.‬";
                break;
            case 101 :
                $message = "عملیات پرداخت قبلا با موفقیت انجام شده است";
                break;
            case -33 :
                $message =" عملیات پرداخت ناموفق بود.‫ندارد‪.‬‬ ‫مطابقت‬ ‫شده‬ ‫پرداخت‬ ‫رقم‬ ‫با‬ ‫تراكنش‬ ‫رقم‬";
                break;
            case -22 :
                $message = "عملیات پرداخت ناموفق بود.";
                break;
            case -1 :
                $message = "اطلاعات ارسال شده ناقص هست";
                break;
            case -21 :
                $message = "هیچ پرداختی برای این تراکنش یافت نشد";
                break;
            case 0 :
                $message = "مبلغ وارد شده صحیح نمی باشد.";
                break;
            case -2 :
                $message = "عملیات پرداخت لغو گردید.";
                break;
            default:
                $message = "عملیات با شکست مواجه شد.";
        }

       if ($status == 100 || $status == 101)
             Alert::html('<span class="IranBold16 fw-600 text-success">عملیات موفق</span>',"<div class=\"Iran14 fw-600 text-info\">{$message}</div>",'success');
       else
            Alert::html('<span class="IranBold16 fw-600 text-danger">عملیات ناموفق</span>',"<div class=\"Iran14 fw-600 text-info\">{$message}</div>",'error');
    }
}