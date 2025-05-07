<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\GetIrlReportRequest;
use App\Mail\SendContactFormMail;
use App\Models\IrlReport;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Encryption\Encrypter;

class FrontController extends Controller
{
    //

    public function getIrlReport(GetIrlReportRequest $request)
    {
        $irlReport = IrlReport::where('reference_no', $request->irl_no)
            ->where('status', IrlReport::PUBLISHED)
            ->where(function ($query) use ($request) {
                return $query->where('email', $request->email_phone)
                ->orWhere('phone', $request->email_phone);
            })
            
            ->first();


        if (!$irlReport) {
            $messageBag = new MessageBag();

            // Add new messages to the message bag.
            $messageBag->add('email_phone', "We didn't find any Reports. Please verify if you have entered the correct details");

            // Get an array of all the messages.
            return  redirect()->back()->withErrors($messageBag);
        }

        return view('web.report', compact('irlReport'));
    }


    public function validateIrlReport(Request $request, $referenceNo, $emailPhone)
    {
        $irlReport = IrlReport::where('reference_no', $referenceNo)
            ->where('status', IrlReport::PUBLISHED)
            ->where(function ($query) use ($emailPhone) {
                return $query->where('email', $emailPhone)
                ->orWhere('phone', $emailPhone);
            })
            
            ->first();


        if (!$irlReport) {
            abort(404);
        }

        return view('web.report', compact('irlReport'));
    }

    public function validateIrlReportEncrypted(Request $request, $encryptedUrl)
    {
        try {
            $decrypted = Crypt::decryptString($encryptedUrl);

            [$referenceNo, $emailPhone] = explode('|', $decrypted);

            $irlReport = IrlReport::where('reference_no', $referenceNo)
            ->where('status', IrlReport::PUBLISHED)
            ->where(function ($query) use ($emailPhone) {
                return $query->where('email', $emailPhone)
                ->orWhere('phone', $emailPhone);
            })
            
            ->first();

            if (!$irlReport) {
                abort(404);
            }
            return view('web.report', compact('irlReport'));
        } catch (DecryptException $e) {
            return abort('403');
        }
    }

    public function validateIrlReportInventoryEncrypted(Request $request, $encryptedUrl)
    {
        try {
            // Use your custom base64 key (store it in .env as base64:YOURKEYHERE)
            $base64Key = env('l1F++HBDxN7pMViR8DIUsn9P9vwdFdFXzgk2hRPP4wM='); // e.g., base64:nP1h1C3MgFbKcZRLulAc13RnykZheLp1qq9kOZ5Shfg=
            $key = base64_decode(explode(':', $base64Key)[1]); // decode from base64
    
            $cipher = 'AES-256-CBC';
            $encrypter = new Encrypter($key, $cipher);
    
            // Decrypt the URL
            $decrypted = $encrypter->decrypt($encryptedUrl);
    
            // Split into referenceNo and skuNumber
            [$referenceNo, $skuNumber] = explode('|', $decrypted);
    
            // Fetch the IRL Report
            $irlReport = IrlReport::where('reference_no', $referenceNo)
                ->where('SKU_no', $skuNumber)
                ->where('status', IrlReport::PUBLISHED)
                ->first();
    
            if (!$irlReport) {
                abort(404);
            }
    
            return view('web.report', compact('irlReport'));
    
        } catch (DecryptException $e) {
            return abort(403);
        }
    }

    public function postContactForm(ContactFormRequest $request)
    {
        $email = env('DEFAULT_MAIL_TO');
   
        $maildata = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'message' => $request->message

        ];
  
        Mail::to($email)->send(new SendContactFormMail($request));

        Session::flash('success', 'Thank you for contacting International Ruraksha Labortary. We will contact you soon ');

        return view('web.contact');
    }
}
