@extends('admin.partial.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            
            {{-- Change Logos --}}
            <div class="card mb-6">
                <h5 class="card-header">Change Logos</h5>
                <form method="POST" action="{{ route('admin.setting-update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Site Logo</label>
                             @if($setting->site_logo)
                                <img src="{{ asset($setting->site_logo) }}" class="mt-2" height="80">
                            @endif
                            <input type="file" name="site_logo" class="form-control">

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Site Favicon</label>
                            @if($setting->site_favicon)
                                <img src="{{ asset($setting->site_favicon) }}" class="mt-2" height="80">
                            @endif
                            <input type="file" name="site_favicon" class="form-control">
                        
                        </div>
                        <button type="submit" class="btn btn-primary">Save Logos</button>
                    </div>
                </form>
            </div>

            {{-- Site Info --}}
            <div class="card mb-6">
                <h5 class="card-header">Change Site Settings</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.setting-update') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Site Name</label>
                                <input type="text" name="site_name" value="{{ $setting->site_name }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile</label>
                                <input type="text" name="site_mobile" value="{{ $setting->site_mobile }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="site_email" value="{{ $setting->site_email }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="site_address" value="{{ $setting->site_address }}" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="site_description" class="form-control">{{ $setting->site_description }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Social Media --}}
            <div class="card">
                <h5 class="card-header">Update Social URLs</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.setting-update') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label">Facebook</label>
                                <input type="url" name="facebook_url" value="{{ $setting->facebook_url }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Twitter</label>
                                <input type="url" name="twitter_url" value="{{ $setting->twitter_url }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instagram</label>
                                <input type="url" name="instagram_url" value="{{ $setting->instagram_url }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">YouTube</label>
                                <input type="url" name="youtube_url" value="{{ $setting->youtube_url }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pinterest</label>
                                <input type="url" name="pinterest_url" value="{{ $setting->pinterest_url }}" class="form-control">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save Social Links</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
