<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;
use App\Services\Msg91Service;
class AuthController extends Controller
{
    public function sendOtpindex(Request $request, TwilioService $twilio)
    {

        return view('frontend.send-otp');
    }

  public function sendOtp(Request $request, Msg91Service $msg91)
{
    $request->validate([
        'phone' => 'required|digits:10',
    ]);

    $response = $msg91->sendOtp($request->phone);

    return response()->json($response);
}

public function verifyOtp(Request $request, Msg91Service $msg91)
{
    $request->validate([
        'phone' => 'required|digits:10',
        'otp' => 'required|digits:6',
    ]);

    $response = $msg91->verifyOtp(
        $request->phone,
        $request->otp
    );

    return response()->json($response);
}
}
