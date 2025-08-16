@extends('admin.partial.auth-app')

@section('content')
@php
    // List of available image filenames
    $images = [
        'Picsart_25-07-25_13-06-38-498.jpg',
        'Picsart_25-07-25_13-07-07-682.jpg',
        'Picsart_25-07-25_13-07-42-016.jpg',
        'Picsart_25-07-25_13-08-10-844.jpg',
        'Picsart_25-07-25_13-08-42-360.jpg',
        'Picsart_25-07-25_13-09-01-719.jpg',
        'Picsart_25-07-25_13-09-44-329.jpg',
    ];

    // Pick a random image
    $randomImage = $images[array_rand($images)];
@endphp
<div class="authentication-wrapper authentication-cover">
  <!-- Logo -->
  <a href="index.html" class="app-brand auth-cover-brand">
    <span class="app-brand-logo demo">
      <span class="text-primary">
        <!-- SVG logo code (unchanged) -->
      </span>
    </span>
    <span class="app-brand-text demo text-heading fw-bold">
        <img src="{{ asset('images/Picsart_25-07-25_13-03-50-331.png') }}" 
             alt="Molla Logo" style="width: 20%;"></span>
    <!-- (keep existing SVG logo here) -->
  </a>
  <!-- /Logo -->

  <div class="authentication-inner row m-0">
    <!-- Left Side Illustration -->
    <div class="d-none d-xl-flex col-xl-8 p-0">
      
      <div class="auth-cover-bg d-flex justify-content-center align-items-center">
          <img src="{{ asset('images/auth/' . $randomImage) }}" class="platform-bg" />
      </div>
    </div>
    <!-- /Left Side -->

    <!-- Login Form -->
    <div class="d-flex col-12 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
      <div class="w-px-400 mx-auto ">


      <div style="text-align: center;padding-bottom: 20px;">
    <a href="index.html" class="logo">
        <img src="{{ asset('images/WhatsApp Image 2025-07-22 at 19.56.01.jpeg') }}" 
             alt="Molla Logo" style="width: 60%;">
    </a>
</div>
                </a>
        <h4 class="mb-1">Welcome to Layerloop</h4>
        <p class="mb-6">Please sign-in to your account and start the adventure</p>

        <!-- Jetstream Validation Errors -->
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (session('status'))
          <div class="alert alert-success text-sm mb-4">
            {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group input-group-merge">
              <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
              <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
            </div>
          </div>

          <div class="d-flex justify-content-between mb-4">
            <div class="form-check mb-0">
              <input class="form-check-input" type="checkbox" id="remember_me" name="remember" />
              <label class="form-check-label" for="remember_me">Remember me</label>
            </div>

            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
          </div>

          <button class="btn btn-primary d-grid w-100">Log in</button>
        </form>

        <p class="text-center mt-4">
          <span>New on our platform?</span>
          <a href="{{ route('register') }}">
            <span>Create an account</span>
          </a>
        </p>

        <div class="divider my-6">
          <div class="divider-text">or</div>
        </div>

        <div class="d-flex justify-content-center">
          <!-- Social buttons -->
          <a href="#" class="btn btn-icon rounded-circle btn-text-facebook me-1_5">
            <i class="icon-base ti tabler-brand-facebook-filled icon-20px"></i>
          </a>
          <a href="#" class="btn btn-icon rounded-circle btn-text-twitter me-1_5">
            <i class="icon-base ti tabler-brand-twitter-filled icon-20px"></i>
          </a>
          <a href="#" class="btn btn-icon rounded-circle btn-text-github me-1_5">
            <i class="icon-base ti tabler-brand-github-filled icon-20px"></i>
          </a>
          <a href="#" class="btn btn-icon rounded-circle btn-text-google-plus">
            <i class="icon-base ti tabler-brand-google-filled icon-20px"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- /Login Form -->
  </div>
</div>
@endsection
