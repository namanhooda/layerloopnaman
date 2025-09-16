<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Banner;

class BannerController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = Banner::latest()->get();

            return DataTables::of($banners)
                ->addIndexColumn()
                ->addColumn('title', fn($row) => $row->title ?? '—')
                ->addColumn('sub_title', fn($row) => $row->sub_title ?? '—')
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $imageUrl = asset($row->image); // stored as 'uploads/banners/filename.jpg'
                        return '<img src="' . $imageUrl . '" width="60" height="60" style="object-fit:cover">';
                    }
                    return '—';
                })
                ->addColumn('mobile_image', function ($row) {
                    if ($row->mobile_image) {
                        $imageUrl = asset($row->mobile_image);
                        return '<img src="' . $imageUrl . '" width="60" height="60" style="object-fit:cover">';
                    }
                    return '—';
                })
                ->addColumn('actions', function ($row) {
                    $editUrl = route('admin.banner.edit', $row->id);
                    $deleteUrl = route('admin.banner.destroy', $row->id);
                
                    $actions = '<div class="d-flex align-items-center">';

                        $actions .= '<a class="btn btn-icon me-1" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-edit icon-22px"></i>
                                    </a>';
                    
                
                        $actions .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure you want to delete this banner?\')">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-sm btn-danger">
                                            <i class="icon-base ti ti-trash icon-22px"></i>
                                        </button>
                                    </form>';
                    
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                ->rawColumns(['image', 'mobile_image', 'actions'])
                ->make(true);
        }

        return view('admin.banner.index');
    }

    public function create()
    {
        return view('admin.banner.create');
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'        => 'required|string|max:255',
                'sub_title'    => 'nullable|string|max:255',
                'url'          => 'nullable|url',
                'price_title'  => 'nullable|string|max:255',
                'price'        => 'nullable|numeric',
                'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $banner = new Banner();
            $banner->title        = $request->title;
            $banner->sub_title    = $request->sub_title;
            $banner->url          = $request->url;
            $banner->price_title  = $request->price_title;
            $banner->price        = $request->price;

            // Handle Image Upload (Desktop)
            if ($request->hasFile('image')) {
                $uploadPath = public_path('uploads/banners');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $imageName = time().'_'.uniqid().'.'.$request->image->extension();
                $request->image->move($uploadPath, $imageName);
                $banner->image = 'uploads/banners/'.$imageName;
            }

            // Handle Image Upload (Mobile)
            if ($request->hasFile('mobile_image')) {
                $mobileName = time().'_mobile_'.uniqid().'.'.$request->mobile_image->extension();
                $request->mobile_image->move(public_path('uploads/banners'), $mobileName);
                $banner->mobile_image = 'uploads/banners/'.$mobileName;
            }

            $banner->save();

        return "success";
            return redirect()->route('admin.banner.index')->with('success', 'Banner created successfully!');
        } catch (\Exception $e) {
            dd($e);
            // Log the error for debugging
            \Log::error('Banner Store Error: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show error message in dev mode
            if (config('app.debug')) {
                return back()->withErrors(['error' => $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine()]);
            }

            // Otherwise, show generic error
            return back()->with('error', 'Something went wrong while saving the banner. Please try again.');
        }
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'url'         => 'nullable|url|max:255',
            'title'       => 'nullable|string|max:255',
            'sub_title'   => 'nullable|string|max:255',
            'price_title' => 'nullable|string|max:255',
            'price'       => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'mobile_image'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Desktop image upload
        if ($request->hasFile('image')) {
            $imageName = 'banner_' . time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/banners'), $imageName);
            $validated['image'] = 'uploads/banners/' . $imageName;

            // Delete old file if exists
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
        }

        // Mobile image upload
        if ($request->hasFile('mobile_image')) {
            $mobileName = 'banner_mobile_' . time() . '.' . $request->mobile_image->getClientOriginalExtension();
            $request->mobile_image->move(public_path('uploads/banners'), $mobileName);
            $validated['mobile_image'] = 'uploads/banners/' . $mobileName;

            if ($banner->mobile_image && file_exists(public_path($banner->mobile_image))) {
                unlink(public_path($banner->mobile_image));
            }
        }

        $banner->update($validated);

        return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        try {
            // Delete desktop image if exists
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }

            // Delete mobile image if exists
            if ($banner->mobile_image && file_exists(public_path($banner->mobile_image))) {
                unlink(public_path($banner->mobile_image));
            }

            // Delete banner record
            $banner->delete();

            return redirect()->route('admin.banner.index')->with('success', 'Banner deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Banner Delete Error: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()->with('error', 'Something went wrong while deleting the banner.');
        }
    }


}
