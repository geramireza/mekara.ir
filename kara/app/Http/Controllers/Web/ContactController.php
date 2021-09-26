<?php

namespace App\Http\Controllers\Web;

use App\Contact;
use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function contact()
    {
        return view("contact");
    }

    public function contactsReports(Request $request)
    {
        $message = $request->message;
        $phone = $request->phone;
        $user = null;
        if($message)
        {
            if ($phone)
                $user = Auth::register($phone);
            Contact::create([
               'user_id' => $user ? $user->id : null,
                'body' => $message
            ]);
            Alert::html('<span class="IranBold16 fw-600 text-success">پیشنهاد شما</span>','<div class="Iran14 fw-600 text-info">انتقاد و یا پیشنهاد شما با موفقیت ثبت شد و در صف بررسی قرار گرفت</div>','success');

        }
        return back();
    }

    public function seenContacts()
    {
        $contactId = Input::post("contactId");
        $checked =  Input::post("checked") == "true" ? 1 : 0;

        $contact = Contact::find($contactId);
        $contact->is_seen = $checked;
        $contact->save();
    }
}
