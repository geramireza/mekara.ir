<?php

namespace App\Http\Controllers\Mobile;

use App\Contact;
use App\Helpers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function contactsReports(Request $request)
    {
        $message = $request->message;
        $phone = $request->phone;
        $user = null;
        if($message)
        {
            if ($phone)
                $user = Auth::register($phone);
           $contact = Contact::create([
                'user_id' => $user ? $user->id : null,
                'body' => $message
            ]);
            $result["result"]  = $contact ? true : false;
        }

        return response()->json($result);
    }

}
