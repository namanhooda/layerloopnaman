<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Blog;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Mail\TestMail;
use App\Mail\WelcomeMail;

use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{

    public function sendMail()
    {
            $title = 'Welcome to the laracoding.com example email';
            $body = 'Thank you for participating!';

            Mail::to('namanhooda86@gmail.com')->send(new WelcomeMail($title, $body));

            return "Email sent successfully!";
    }
    public function index()
    {   
        if (!session()->has('visitor_tracked')) {
            session()->put('visitor_tracked', true);
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url'        => $request->fullUrl(),
                'visited_at' => now(),
            ]);
        }

        $categories = ProductCategory::whereIn('id', [13, 14, 12, 8, 1, 2])
            ->orderByRaw('FIELD(id, 13, 14, 12, 8, 1, 2)')
            ->get(); 
        $trending = Product::where('prototype',2)->latest()->take(10)->get(); // Latest 10 products
        $collection = Product::where('prototype',2)->latest()->take(10)->get(); // Latest 10 products

        $featured = Product::where('prototype',2)->latest()->take(10)->get(); // Latest 10 products trending
        $clothes     = Product::where('category',2)->inRandomOrder()->take(10)->get(); // 10 random products

        $sale     = Product::where('prototype',2)->inRandomOrder()->take(10)->get(); // 10 random products
        $rated    = Product::where('prototype',2)->take(20)->get();    

        $blogs    = Blog::get();
        return view('frontend.index', compact('featured','sale','rated','clothes','blogs','categories','collection'));
    }
    public function about()
    {
        return view('frontend.about');
    }
    public function gallary()
    {
        return view('frontend.gallary');
    }
    public function contactUs()
    {
        return view('frontend.contactUs');
    }
    public function faq()
    {
        return view('frontend.faq');
    }
    public function blogs()
    {
        $blogs    = Blog::get();
        return view('frontend.blogs', compact('blogs'));
    }
    public function blogDetail($slug)
    {
        $blogs    = Blog::get();
        $blog = Blog::where('slug', $slug)->first();
        return view('frontend.blogDetail', compact('blog','blogs'));
    }


    public function shop(Request $request)
    {
        $query = $request->input('q');
        $filter = $request->input('filter');

        $products = Product::query();

        if ($query) {
            $products->where('name', 'like', '%' . $query . '%');
        }

        if ($filter === 'clothing') {
            $products->where(function ($q) {
                $q->where('prototype', 'clothing')
                ->orWhere('prototype', 1);
            }); // adjust to match your DB field
        }elseif ($filter === 'customize') {
            $products->where('prototype', 'customize'); // adjust to match your DB field
        }else{
            $products->where(function ($q) {
                $q->where('prototype', 'object')
                ->orWhere('prototype', 2);
            });

        }
$products = $products->latest()->get();

$productsCount = $products->count();
$categories = ProductCategory::all();
        return view('frontend.shop', compact('products', 'query', 'filter', 'productsCount','categories'));
    }
    public function categoryProduct(Request $request, $category_name)
    {

        $categories = ProductCategory::where('slug', $category_name)
            ->first();
        $products = Product::where('category', $categories->id)->get();

        return view('frontend.category_product', compact('products','category_name'));
    }
    public function searchSuggestions(Request $request)
{
    $query = $request->input('q');

    $products = Product::where('name', 'like', '%' . $query . '%')
                ->select('id', 'name') // assuming you have 'slug' column
                ->limit(5)
                ->get();

    return response()->json($products);
}
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $related = Product::where('category', $product->category)->take(10)->get();
        return view('frontend.detail',compact('product','related'));
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'description' => 'required|string',
            'title' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }
        ProductReview::create([
            'product_id' => $validated['product_id'],
            'user_id' => auth()->check() ? auth()->id() : null,
            'review' => $validated['description'],
            'title' => $validated['title'],
            'rating' => $validated['rating'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
