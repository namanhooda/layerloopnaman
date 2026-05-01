<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

use Barryvdh\DomPDF\Facade\Pdf;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $files = Storage::disk('public')->files('Uploadsdata');

    $products = [];

    foreach ($files as $file) {

        $filename = basename($file);

        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);

        $nameafter = $nameWithoutExt.' (5 inch)';

        $slug = Str::slug($nameafter);

        // ✅ skip if already exists
        if (Product::where('slug', $slug)->exists()) {
            continue;
        }

        $products[] = [
            'name' => Str::title(str_replace('-', ' ', $nameafter)),
            'slug' => $slug.'-'.Str::lower(Str::random(4)), // extra safe
            'code' => 'LL'.str_pad(mt_rand(0,99999999),8,'0',STR_PAD_LEFT),

            'prototype' => 2,
            'category' => 12,
            'status' => 'Published',

            'featured_image' => 'product_featured/'.$filename,

            'price' => 599,
            'discounted_price' => 599,

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



public function downloadPdf()
{

    $products = Product::whereIn('category', [12, 13])
    ->inRandomOrder()
    ->get();
    // dd($products);

    $pdf = Pdf::loadView('pdf.products', compact('products'));
    return $pdf->download('products.pdf');

    return $pdf->stream('products.pdf');


    $pdf = Pdf::loadView('pdf.products');

    return $pdf->download('products.pdf');
}



public function downloadPdfwork()
{
    
set_time_limit(120); // 2 minutes
ini_set('max_execution_time', 120);
    ini_set('memory_limit', '512M');

    $files = collect(Storage::disk('public')->files('Ourwork'))
        ->filter(fn($f) => preg_match('/\.(jpg|jpeg|png)$/i', $f))
        ->take(248);

    $processed = [];

    foreach ($files as $file) {

        $originalPath = storage_path('app/public/' . $file);
        if (!file_exists($originalPath)) continue;

        // create temp folder
        $tempDir = storage_path('app/public/temp');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $tempPath = $tempDir . '/temp_' . uniqid() . '.jpg';

        // 🔥 resize using native GD
        $image = imagecreatefromstring(file_get_contents($originalPath));

        if (!$image) continue;

        $width = imagesx($image);
        $height = imagesy($image);

        $newWidth = 800;
        $newHeight = ($height / $width) * $newWidth;

        $tmp = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled(
            $tmp, $image,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $width, $height
        );

        // save compressed
        imagejpeg($tmp, $tempPath, 70);

        imagedestroy($image);
        imagedestroy($tmp);

        $processed[] = $tempPath;
    }

    $pdf = Pdf::loadView('pdf.work', ['files' => $processed]);

    return $pdf->stream('our-work.pdf');
}

}
