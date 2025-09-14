@extends('frontend.partials.app')
@section('content')

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">My Account<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{url('account')}}">Account</a></li>
						<li class="breadcrumb-item active" aria-current="page">Account Settings</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="dashboard">
	                <div class="container">
	                	<div class="row">

                            @include('frontend.user.aside')
	                		<div class="col-md-8 col-lg-9">
	                			<div class="tab-content">
								    <div class="tab-pane fade show active" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                		<h5>Login & Security</h5>
								    	<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
											@csrf
											@method('PUT')

			                				<!-- <div class="row">
			                					<div class="col-sm-6">
			                						<label>First Name *</label>
			                						<input type="text" class="form-control" value="{{Auth::user()->name}}" required>
			                					</div>

			                					<div class="col-sm-6">
			                						<label>Last Name *</label>
			                						<input type="text" class="form-control" required>
			                					</div>
			                				</div> -->

		            						<label>Display Name *</label>
		            						<input type="text" class="form-control" name="name" value="{{Auth::user()->name}}" required>
		            						<small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>

											<label>Profile Photo</label>
											<input type="file" class="form-control mb-2" name="profile_photo">

		            						<label>Mobile *</label>
		            						<input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}" required>

		                					<label>Email address *</label>
		        							<input type="email" class="form-control" name="email" value="{{Auth::user()->email}}" required>

		            						<label>Current password (leave blank to leave unchanged)</label>
		            						<input type="password" class="form-control">

		            						<label>New password (leave blank to leave unchanged)</label>
		            						<input type="password" class="form-control">

		            						<label>Confirm new password</label>
		            						<input type="password" class="form-control mb-2">

		                					<button type="submit" class="btn btn-outline-primary-2">
			                					<span>SAVE CHANGES</span>
			            						<i class="icon-long-arrow-right"></i>
			                				</button>
			                			</form>
								    </div><!-- .End .tab-pane -->
								</div>
	                		</div><!-- End .col-lg-9 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main>

@endsection
