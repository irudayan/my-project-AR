<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\contactusreport;
use App\Mail\contactus;

class ContactusController extends Controller
{
    public function sendmessage(Request $request)
    { 
        $input = $request->all();
        $data  = new contactusreport($input);
        $data->save();

        $contactusreport = contactusreport::all();

        $bodyContent = [        
                        'toName' => $input['name'],
                        'email' => $input['email'],
                        'subject' => $input['subject'],
                        'Message'=> $input['message'],
                    ];

        $email = "";
        
        // try {
        //     Mail::to($email)->send(new contactus($bodyContent));
        $msg = "success";
        // }catch (\Exception $e) {
        //     $msg = "not sent";
        // }

        return response()->json(['data'=> $msg]); 
    }
}
