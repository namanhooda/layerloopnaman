<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ProductReview;
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
        
            // Save visitor info
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url'        => $request->fullUrl(),
                'visited_at' => now(),
            ]);
        
        }
        $featured = Product::latest()->take(10)->get(); // Latest 10 products
        $sale     = Product::inRandomOrder()->take(10)->get(); // 10 random products
        $clothes     = Product::where('category','tshirts')->inRandomOrder()->take(10)->get(); // 10 random products
        $rated    = Product::take(10)->get();    
        return view('frontend.index',compact('featured','sale','rated','clothes'));
    }
    public function about()
    {
        return view('frontend.about');
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
        return view('frontend.blogs');
    }
    public function blogDetail()
    {
        return view('frontend.blogDetail');
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
            $products->where('prototype', 'clothing'); // adjust to match your DB field
        }

        if ($filter === 'customize') {
            $products->where('prototype', 'customize'); // adjust to match your DB field
        }

        $products = $products->get();

        return view('frontend.shop', compact('products', 'query', 'filter'));
    }
    public function categoryProduct(Request $request, $category_name)
    {
        $products = Product::where('category', $category_name)->get();

        return view('frontend.category_product', compact('products'));
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
    public function detail($id)
    {
        $product = Product::find($id);
        $related = Product::get();
        return view('frontend.detail',compact('product','related'));
    }
    public function account()
    {
        return view('frontend.account');
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
