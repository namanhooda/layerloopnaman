<aside class="col-md-4 col-lg-3">
    <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('orders') ? 'active' : '' }}" href="{{ url('orders') }}">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('account-settings') ? 'active' : '' }}" href="{{ url('account-settings') }}">Login & Security</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('addresses') ? 'active' : '' }}" href="{{ url('addresses') }}">Addresses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('wallet') ? 'active' : '' }}" href="{{ url('wallet') }}">Wallet</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</aside>
