<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;use App\Models\WhatsappMessage;


class WhatsappController extends Controller
{
    //
// Show form
    public function form()
    {
        return view('whatsapp.form');
    }

    // Handle sending message
    public function send(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'message' => 'required',
        ]);

        $msg = WhatsappMessage::create([
            'number' => $request->number,
            'message' => $request->message,
        ]);

        return response()->json(['status' => 'Message queued!', 'id' => $msg->id]);
    }
}
