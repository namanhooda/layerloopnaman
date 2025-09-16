<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $setting = Setting::first();

        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_mobile' => 'nullable|string|max:20',
            'site_email' => 'nullable|email|max:255',
            'site_address' => 'nullable|string|max:500',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:800',
            'site_favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico|max:500',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'pinterest_url' => 'nullable|url',
        ]);

        // Handle site_logo upload (save in public/)
       if ($request->hasFile('image')) {
            $imageName = 'banner_' . time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/banners'), $imageName);
            $banner->image = 'uploads/banners/' . $imageName;
        }

        // Handle Image Upload (Mobile)
        if ($request->hasFile('mobile_image')) {
            $mobileName = 'banner_mobile_' . time() . '.' . $request->mobile_image->getClientOriginalExtension();
            $request->mobile_image->move(public_path('uploads/banners'), $mobileName);
            $banner->mobile_image = 'uploads/banners/' . $mobileName;
        }

        // Update text fields
        $setting->fill($request->only([
            'site_name',
            'site_description',
            'site_mobile',
            'site_email',
            'site_address',
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'youtube_url',
            'pinterest_url',
        ]));

        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
