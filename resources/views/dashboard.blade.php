@extends('admin.partial.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">

        <div class="col-xl-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body text-nowrap">
                            <h5 class="card-title mb-0">Welcome {{Auth::user()->name}}! 🎉</h5>
                            <p class="mb-2">Total Sale This Month</p>
                            <h4 class="text-primary mb-1">₹{{$arrayData['totalsalethismonth']}}</h4>
                            <a href="javascript:;" class="btn btn-primary">View Sales</a>
                        </div>
                    </div>
                    <div class="col-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{('backend/assets/img/illustrations/card-advance-sale.png')}}" height="140"
                                alt="view sales" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Statistics</h5>
                    <small class="text-body-secondary"></small>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div class="w-100">
                        <div class="row gy-3">
                            <div class="col-md-3 col-6">
                                <a href="{{url('admin/orders')}}">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-primary me-4 p-2">
                                        <i class="icon-base ti tabler-chart-pie-2 icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$arrayData['totalOrders']}}</h5>
                                        <small>Orders</small>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <a href="{{url('admin/users')}}">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-info me-4 p-2">
                                        <i class="icon-base ti tabler-users icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$arrayData['totalUsers']}}</h5>
                                        <small>Customers</small>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <a href="{{url('admin/products')}}">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-danger me-4 p-2">
                                        <i class="icon-base ti tabler-shopping-cart icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$arrayData['totalProduct']}}</h5>
                                        <small>Products</small>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded bg-label-success me-4 p-2">
                                        <i class="icon-base ti tabler-currency-dollar icon-lg"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">₹{{$arrayData['totalSale']}}</h5>
                                        <small>Revenue</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Website Analytics -->
        <div class="col-xl-8 col">
            <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg"
                id="swiper-with-pagination-cards">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="row">
                            <h2>Website Analytics (Last 7 Days)</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Active Users</th>
                                        <th>Page Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($report as $row)
                                    @php
                                        $date = \Carbon\Carbon::createFromFormat(
                                            'Ymd',
                                            $row->getDimensionValues()[0]->getValue()
                                        )->format('d F Y');
                                    @endphp
                                    <tr>
                                        <td>{{ $date }}</td>
                                        <td>{{ $row->getMetricValues()[0]->getValue() }}</td>
                                        <td>{{ $row->getMetricValues()[1]->getValue() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!--/ Website Analytics -->


                <div class="col-xxl-4 col-md-6">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="mb-1">Earning Reports</h5>
                        <p class="card-subtitle">Earnings Overview</p>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1"
                          type="button"
                          id="earningReports"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                          <a class="dropdown-item" href="javascript:void(0);">Download</a>
                          <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                          <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pb-0">
                      <ul class="p-0 m-0">
                        <li class="d-flex align-items-center mb-5">
                          <div class="me-4">
                            <span class="badge bg-label-primary rounded p-1_5"
                              ><i class="icon-base ti tabler-chart-pie-2 icon-md"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Net Profit</h6>
                              <small class="text-body">12.4k Sales</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-4">
                              <small>$1,619</small>
                              <div class="d-flex align-items-center gap-1">
                                <i class="icon-base ti tabler-chevron-up text-success"></i>
                                <small class="text-body-secondary">18.6%</small>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                          <div class="me-4">
                            <span class="badge bg-label-success rounded p-1_5"
                              ><i class="icon-base ti tabler-currency-dollar icon-md"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Total Income</h6>
                              <small class="text-body">Sales, Affiliation</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-4">
                              <small>$3,571</small>
                              <div class="d-flex align-items-center gap-1">
                                <i class="icon-base ti tabler-chevron-up text-success"></i>
                                <small class="text-body-secondary">39.6%</small>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                          <div class="me-4">
                            <span class="badge bg-label-secondary text-body rounded p-1_5"
                              ><i class="icon-base ti tabler-credit-card icon-md"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Total Expenses</h6>
                              <small class="text-body">ADVT, Marketing</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-4">
                              <small>$430</small>
                              <div class="d-flex align-items-center gap-1">
                                <i class="icon-base ti tabler-chevron-up text-success"></i>
                                <small class="text-body-secondary">52.8%</small>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                      <div id="reportBarChart"></div>
                    </div>
                  </div>
                </div>


        <!-- Average Daily Sales -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h5 class="mb-3 card-title">Average Daily Sales</h5>
                    <p class="mb-0 text-body">Total Sales This Month</p>
                    <h4 class="mb-0">$28,450</h4>
                </div>
                <div class="card-body px-0">
                    <div id="averageDailySales"></div>
                </div>
            </div>
        </div>
        <!--/ Average Daily Sales -->

        <!-- Sales Overview -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 text-body">Sales Overview</p>
                        <p class="card-text fw-medium text-success">+18.2%</p>
                    </div>
                    <h4 class="card-title mb-1">$42.5k</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <span class="badge bg-label-info p-1 rounded"><i
                                        class="icon-base ti tabler-shopping-cart icon-sm"></i></span>
                                <p class="mb-0">Order</p>
                            </div>
                            <h5 class="mb-0 pt-1">62.2%</h5>
                            <small class="text-body-secondary">6,440</small>
                        </div>
                        <div class="col-4">
                            <div class="divider divider-vertical">
                                <div class="divider-text">
                                    <span class="badge-divider-bg bg-label-secondary">VS</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                <p class="mb-0">Visits</p>
                                <span class="badge bg-label-primary p-1 rounded"><i
                                        class="icon-base ti tabler-link icon-sm"></i></span>
                            </div>
                            <h5 class="mb-0 pt-1">25.5%</h5>
                            <small class="text-body-secondary">12,749</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-6">
                        <div class="progress w-100" style="height: 10px">
                            <div class="progress-bar bg-info" style="width: 70%" role="progressbar" aria-valuenow="70"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 30%"
                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Sales Overview -->

  
    </div>
</div>
@endsection
