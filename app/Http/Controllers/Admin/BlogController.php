<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blogs = Blog::with('category')->latest()->get();

        if ($request->ajax()) {
            return DataTables::of($blogs)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => $row->title)
                ->addColumn('slug', fn($row) => $row->slug)
                ->addColumn('featured_image', function ($row) {
                    if ($row->featured_image) {
                        $imageUrl = asset('storage/' . $row->featured_image);
                        return '<img src="' . $imageUrl . '" width="60" height="60" style="object-fit:cover">';
                    }
                    return '—';
                })
                ->addColumn('category', fn($row) => $row->category->name ?? '—')
                ->addColumn('author_name', fn($row) => $row->author_name)
                ->addColumn('publish_at', fn($row) => optional($row->publish_at)->format('d M Y, h:i A') ?? '—')
                ->addColumn('actions', function ($row) {
                    $editUrl = route('admin.blogs.edit', $row->id);
                    $deleteUrl = route('admin.blogs.destroy', $row->id);
                
                    $actions = '<div class="d-flex align-items-center">';
                
                    if (auth()->user()->can('blog edit')) {
                        $actions .= '<a class="btn btn-icon me-1" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-edit icon-22px"></i>
                                     </a>';
                    }
                
                    if (auth()->user()->can('blog delete')) {
                        $actions .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure you want to delete this blog?\')">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-sm btn-danger">
                                            <i class="icon-base ti ti-trash icon-22px"></i>
                                        </button>
                                    </form>';
                    }
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                
                ->rawColumns(['featured_image', 'actions'])
                ->make(true);
        }

        return view('admin.blog.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::latest()->get();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|unique:blogs,slug',
            'category_id' => 'required|exists:blog_categories,id',
            'author_name' => 'required',
            'content' => 'required',
        ]);
    
        $data = $request->all();
        $data['slug'] = $request->slug ?? Str::slug($request->title);
        $data['seo_schema'] = $request->seo_schema ? json_decode($request->seo_schema, true) : null;
    
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }
    
        Blog::create($data);
    
        return redirect()->route('admin.blogs.index')->with('success', 'Blog created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::latest()->get();
        return view('admin.blog.edit', compact('blog','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'tags' => 'nullable|string',
                'category_id' => 'required|exists:blog_categories,id',
                'author_name' => 'required|string|max:255',
                'content' => 'nullable|string',
                'status' => 'required|in:draft,published,archived',
                'publish_at' => 'nullable|date',
                'meta_data' => 'nullable|string',
                'seo_schema' => 'nullable|json',
            ]);
        
            // Handle file upload
            if ($request->hasFile('featured_image')) {
                // Delete old image if exists
                if ($blog->featured_image && \Storage::exists('public/' . $blog->featured_image)) {
                    \Storage::delete('public/' . $blog->featured_image);
                }
        
                $path = $request->file('featured_image')->store('blogs', 'public');
                $validatedData['featured_image'] = $path;
            }
        
            $blog->update($validatedData);
        
            return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
