<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $files = Storage::disk('public')->files('tshirtdesign');

    $products = [];

    foreach ($files as $file) {

        $filename = basename($file);

        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);

        $nameafter = 'round neck '.$nameWithoutExt.' dtf printed tshirt';

        $slug = Str::slug($nameafter);

        // ✅ skip if already exists
        if (Product::where('slug', $slug)->exists()) {
            continue;
        }

        $products[] = [
            'name' => Str::title(str_replace('-', ' ', $nameafter)),
            'slug' => $slug.'-'.Str::lower(Str::random(4)), // extra safe
            'code' => 'LL'.str_pad(mt_rand(0,99999999),8,'0',STR_PAD_LEFT),

            'prototype' => 1,
            'category' => 2,
            'status' => 'Published',

            'featured_image' => 'product_featured/'.$filename,

            'price' => 499,
            'discounted_price' => 499,

            'charge_tax' => 1,
            'stock_quantity' => 100,
            'in_stock' => 1,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // ✅ single query insert (10x faster)
    Product::insert($products);

    dd(count($products).' products imported successfully ✅');
}

    public function form()
    {
        return view('test.form');
    }

public function bulkUpload(Request $request)
{
    $request->validate([
        'images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240', // max 10MB
    ]);

    try {
        $uploadedCount = 0;

    dd('mmm');
        foreach ($request->file('images') as $image) {
            $nameWithoutExt = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '_' . Str::random(5) . '.' . $extension;

            // Store image in public storage
            $path = $image->storeAs('product_images', $filename, 'public');

            // Create Product entry
            Product::create([
                'name' => 'Trending T-shirt Article ' . ($index + 1),
                'featured_image' => $path,
                'price' => 499,
                'discounted_price' => 499,
                'category' => 'tshirts',
                'prototype' => 'clothing',
                'stock_quantity' => 10,
                'in_stock' => 1,
                'code' => 'LL' . rand(10000000, 99999999), // LL + 8 random numbers
            ]);

            $uploadedCount++;
        }

        return back()->with('success', "$uploadedCount products uploaded successfully!");
    } catch (\Exception $e) {
        // Log the error
        dd($e);
        return back()->with('error', 'Something went wrong during bulk upload. Please try again!');
    }
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
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
