<?php

namespace App\Http\Controllers\Payment;

use App\Constants;
use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SoapClient;

class AppPaymentController extends Controller
{
    private $postType;
    private $isEmergency;
    private $isExtended;
    private $isLadder;
    private $postId;
    private $phone;

    public function paymentRequest(Request $request)
    {
        $dataArray = json_decode($request->data,true);
        $this->postType = isset($dataArray["postType"]) ? $dataArray["postType"] : false;
        $this->isEmergency = isset($dataArray["isEmergency"]) ? $dataArray["isEmergency"] : false;
        $this->isExtended = isset($dataArray["isExtended"]) ? $dataArray["isExtended"] : false;
        $this->isLadder = isset($dataArray["isLadder"]) ? $dataArray["isLadder"] : false;
        $this->phone = $dataArray["phone"];
        $this->postId = $dataArray["postId"];

        $post = $this->getPostParams();
        $payment = new \App\Payment();
        $amount = $post->price;

        $description = Constants::STR_PAY_DESCRIPTION;
        $data = [
            'MerchantID' =>Constants::ZARINPAL_MERCHANT_ID,
            'Amount' => $amount,
            'Description' => $description,
            'Mobile' =>$this->phone,
            'CallbackURL' =>Constants::ZARINPAL_APP_CALLBACK_URL .$post->id
        ];

        if ($amount != 0)
        {
            $client = new SoapClient(Constants::ZARINPAL_PURCHASE_URL,["encoding" => "UTF-8"]);
            $result = $client->paymentRequest($data);
            $user = User::where("phone",$this->phone)->first();
            if ($result->Status == 100){
                $payment->create([
                    "post_id" => $post->id,
                    "user_id" => $user->id,
                    "amount"  => $amount,
                    "post_life" => $post->post_life,
                    "is_emergency" => $this->isEmergency ?: $post->is_emergency,
                    "is_extended" => $this->isExtended ?: $post->is_extended,
                    "is_ladder" => $this->isLadder ?: 0,
                    "gate" => "zarinpalApp",
                    "transaction_id" => $result->Authority
                ]);
                Header('Location:' . Constants::ZARINPAL_PAYMENT_URL . $result->Authority);
                exit(); // this is important;
            }
            else
            {
                $status = $result->Status;
                $message = $this->setMessage($status);
                return view("layouts.pay-callback",compact("post","payment","status","message"));
            }
        }else
        {
            $status = 0;
            $message = $this->setMessage($status);
            return view("layouts.pay-callback",compact("post","payment","status","message"));
        }
    }

    public function paymentVerify(Request $request)
    {
        $postId = $request->postId;
        $authority = $request->Authority;
        $status = $request->Status;
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
            $message = $this->setMessage($status);
        }else{
            $status = -2;
            $message = $this->setMessage($status);
        }

        $post = Post::find($postId);
        return view("layouts.pay-callback",compact("post","payment","status","message"));

    }

    private function setChangePost($payment)
    {
        $post = Post::find($payment->post_id);
        $post->is_emergency = $payment->is_emergency;
        $post->post_life = $payment->post_life;
        $post->is_extended = $payment->is_extended;
        $post->is_pay = 1;
        $post->is_delete = 0;
        $post->is_expired = 0;
        $post->updated_at = Carbon::now();
        if ($payment->is_ladder == 1)
            $post->published_at = Carbon::now();
        $post->save();
    }

    public function getPostParams()
    {
        $price = 0;
        $post = Post::find($this->postId);
        $prices = $this->getPrices();
        if($this->postType)
        {
            if($this->postType == Constants::KEY_MONTHLY)
            {
                $price += $prices->monthly;
                $post->post_life = 30;
            }
            elseif($this->postType == Constants::KEY_WEEKLY)
            {
                $price += $prices->weekly;
                $post->post_life = 7;
            }
            elseif($this->postType == Constants::KEY_MONTHLY_KARJOO)
            {
                $price += $prices->monthlyKarjoo;
                $post->post_life = 30;
            }
            elseif($this->postType == Constants::KEY_WEEKLY_KARJOO)
            {
                $price += $prices->weeklyKarjoo;
                $post->post_life = 7;
            }
        }
        if($this->isEmergency)
        {
            $price += $prices->emergency;
            $post->is_emergency = 1;
        }
        if($this->isExtended)
        {
            $price += $prices->extended;
            $post->is_extended = 1;
        }
        if($this->isLadder)
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
    public function setMessage($status)
    {
        switch ($status)
        {
            case 100 :
                $message = "عملیات پرداخت با موفقیت انجام شد و آگهی جهت بررسی در صف تایید قرار گرفت.‬";
                break;
            case 101 :
                $message = "عملیات پرداخت قبلا با موفقیت انجام شده است.";
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

        return $message;
    }


}