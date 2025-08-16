<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'company'        => 'nullable|string|max:255',
            'country'        => 'required|string|max:255',
            'address_line1'  => 'required|string|max:255',
            'address_line2'  => 'nullable|string|max:255',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:255',
            'zip'            => 'required|string|max:20',
            'phone'          => 'required|string|max:20',
            'email'          => 'required|email|max:255',
        ]);

        $address = new Address();
        $address->user_id       = Auth::id(); // assumes user is logged in
        $address->first_name    = $request->first_name;
        $address->last_name     = $request->last_name;
        $address->company       = $request->company;
        $address->country       = $request->country;
        $address->address_line1 = $request->address_line1;
        $address->address_line2 = $request->address_line2;
        $address->city          = $request->city;
        $address->state         = $request->state;
        $address->zip           = $request->zip;
        $address->phone         = $request->phone;
        $address->email         = $request->email;

        $address->save();

        return redirect()->back()->with('success', 'Address saved successfully!');
    }
}
