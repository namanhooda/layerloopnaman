<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = Service::latest()->get(); 

        if ($request->ajax()) {
            return DataTables::of($pages)
                ->addIndexColumn()

                ->addColumn('title', fn($row) => $row->title)

                ->addColumn('slug', fn($row) => $row->slug)

                ->addColumn('actions', function ($row) {
                    $buttons = '<div class="d-flex align-items-center">';

                    if (auth()->user()->can('pages edit')) {
                        $editUrl = route('admin.pages.edit', $row->slug);
                        $buttons .= '<a class="btn btn-icon me-1" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-edit icon-22px"></i>
                                    </a>';
                    }
                    $buttons .= '</div>';

                    return $buttons;
                })

                ->rawColumns(['thumbnail_image', 'actions'])
                ->make(true);
        }

        return view('admin.pages.index', compact('pages'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'meta_data' => 'nullable|string',
            'json_ld' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            $slug = $request->slug ?? Str::slug($request->title);
    
            $data = $request->only([
                'title', 'content', 'meta_title', 'meta_description',
                'meta_keywords', 'canonical_url',
                'og_title', 'og_description',
                'twitter_title', 'twitter_description', 'json_ld', 'meta_data',
            ]);
    
            $data['slug'] = $slug;
    
            if ($request->hasFile('og_image')) {
                $data['og_image'] = $request->file('og_image')->store('seo/og', 'public');
            }
    
            if ($request->hasFile('twitter_image')) {
                $data['twitter_image'] = $request->file('twitter_image')->store('seo/twitter', 'public');
            }
    
            $page = Page::where('slug', $slug)->first();
    
            if ($page) {
                $page->update($data);
                $message = 'Page updated successfully.';
            } else {
                Page::create($data);
                $message = 'Page created successfully.';
            }
    
            return redirect()->route('admin.pages.index')->with('success', $message);
    
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save page. Error: ' . $e->getMessage());
        }
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = Page::where('slug', $id)->first();
        $service = Service::where('slug', $id)->first();
        return view('admin.pages.edit', compact('page','service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'json_ld' => 'nullable|string',
            'meta_data' => 'nullable|string',
        ]);

        $data = $request->only([
            'title', 'slug', 'content', 'meta_title', 'meta_description',
            'meta_keywords', 'canonical_url',
            'og_title', 'og_description',
            'twitter_title', 'twitter_description', 'json_ld', 'meta_data',
        ]);

        $data['slug'] = $request->slug ?? Str::slug($request->title);

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo/og', 'public');
        }

        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('seo/twitter', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Page deleted successfully.');
    }
}
