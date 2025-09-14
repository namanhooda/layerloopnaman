@extends('frontend.partials.app')
@section('content')
<style>
    .wallet-box {
        display: flex;
        justify-content: space-between;
        /* pushes balance left, button right */
        align-items: center;
        /* keeps them vertically aligned */
        padding: 10px;
    }th {
    padding-left: 10px !important;
}

td {
    padding-left: 10px !important;
}

</style>

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Wallet<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('account')}}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row">

                    @include('frontend.user.aside')
                    <div class="col-md-8 col-lg-9">
    <div class="wallet-box mb-4 d-flex justify-content-between align-items-center">
        <h4>Wallet Balance: {{ $wallet ? number_format($wallet->balance, 2) : '0.00' }}</h4>
        <button class="btn btn-sm btn-outline-primary my-button">Add Balance</button>
    </div>

    <h6 class="mb-3">Wallet Transactions</h6>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Type</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
                <tr>
                    <td>
                        @if($tx->type === 'credit')
                            <span class="badge bg-success">Credit</span>
                        @else
                            <span class="badge bg-danger">Debit</span>
                        @endif
                    </td>
                    <td>{{ number_format($tx->amount, 2) }}</td>
                    <td>{{ $tx->source }}</td>
                    <td>{{ $tx->description }}</td>
                    <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No Transactions Yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main>

@endsection
