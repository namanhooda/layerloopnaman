<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <img src="{{ asset('images/WhatsApp Image 2025-07-22 at 19.56.01.jpeg') }}" alt="Molla Logo"
                style="width: 100%;">
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ request()->is('admin/dashboard') ? 'active open' : '' }}">
            <a href="{{route('dashboard')}}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        <!-- eCommerce -->
        <li class="menu-item {{ request()->routeIs('admin.ecom.*') || request()->routeIs('admin.products.*') || request()->routeIs('admin.product-categories.*') || request()->routeIs('admin.orders.*')  || request()->routeIs('admin.coupons.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shopping-cart"></i>
                <div data-i18n="eCommerce">eCommerce</div>
            </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.index') }}" class="menu-link">
                                <div data-i18n="Product List">Product List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.create') }}" class="menu-link">
                                <div data-i18n="Add Product">Add Product</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.product-prototypes.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.product-prototypes.index') }}" class="menu-link">
                                <div data-i18n="Proto Types">Proto Types</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.product-categories.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.product-categories.index') }}" class="menu-link">
                                <div data-i18n="Category List">Category List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.coupons.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.coupons.index') }}" class="menu-link">
                                <div data-i18n="Coupons">Coupons</div>
                            </a>
                        </li>
                    </ul>
        </li>
        <!-- Profile -->
        <li class="menu-item  {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
            <a href="{{ route('admin.orders.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-user"></i>
                <div data-i18n="Order List">Order List</div>
            </a>
        </li>

        <!-- Users -->

        <!-- Roles & Permissions -->
        @can('role read')
        <li class="menu-item {{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shield-lock"></i>
                <div data-i18n="Roles & Permissions">Roles & Permissions</div>
            </a>
            <ul class="menu-sub">
                @can('role read')
                <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}" class="menu-link">
                        <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
                @endcan
                @can('permissions read')
                <li class="menu-item {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                        <div data-i18n="Permission">Permission</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        <!-- Blogs -->
        @can('blog read')
        <li class="menu-item {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-categories.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-news"></i>
                <div data-i18n="Blogs">Blogs</div>
            </a>
            <ul class="menu-sub">
                @can('blog categories read')
                <li class="menu-item {{ request()->routeIs('admin.blog-categories.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.blog-categories.index') }}" class="menu-link">
                        <div data-i18n="Blogs Categories">Blog Categories</div>
                    </a>
                </li>
                @endcan
                @can('blog read')
                <li class="menu-item {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.index') }}" class="menu-link">
                        <div data-i18n="Blogs">Blog</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('blog read')
        <li class="menu-item {{ request()->routeIs('orders.nimbusShipment.*') || request()->routeIs('orders.ShiprocketShipment.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-news"></i>
                <div data-i18n="Blogs">Shipments</div>
            </a>
            <ul class="menu-sub">
                @can('blog categories read')
                <li class="menu-item {{ request()->routeIs('orders.nimbusShipment') ? 'active' : '' }}">
                    <a href="{{ route('orders.nimbusShipment') }}" class="menu-link">
                        <div data-i18n="Fetch Nimbus Shipments">Fetch Nimbus Shipments</div>
                    </a>
                </li>
                @endcan
                @can('blog read')
                <li class="menu-item {{ request()->routeIs('orders.ShiprocketShipment') ? 'active' : '' }}">
                    <a href="{{ route('orders.ShiprocketShipment') }}" class="menu-link">
                        <div data-i18n="Fetch Shiprocket Shipments">Fetch Shiprocket Shipments</div>
                    </a>
                </li>
                @endcan
                @can('blog read')
                <li class="menu-item {{ request()->routeIs('orders.shipcheckout') ? 'active' : '' }}">
                    <a href="{{ route('orders.shipcheckout') }}" class="menu-link">
                        <div data-i18n="Checkout Order">Checkout Order</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

       

        <!-- SEO Pages -->
        @can('pages read')
        <li class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <a href="{{ route('admin.pages.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-file-description"></i>
                <div data-i18n="Seo Pages">Seo Pages</div>
            </a>
        </li>
        @endcan
        @can('users read')
        <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-user"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>
        @endcan

        <!-- Email Subscriptions -->
        <li class="menu-item {{ request()->routeIs('admin.newsletters.index') ? 'active' : '' }}">
            <a href="{{ route('admin.newsletters.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-mail"></i>
                <div data-i18n="Email Subscriptions">Email Subscriptions</div>
            </a>
        </li>

        <!-- Profile -->
        <li class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <a href="{{ route('admin.profile.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-user"></i>
                <div data-i18n="Profile">Profile</div>
            </a>
        </li>
        <!-- Profile -->
        <li class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <a href="{{ route('admin.setting.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-settings"></i>

                <div data-i18n="Setting">Setting</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <a href="{{ route('orders.nimbusShipment') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-settings"></i>

                <div data-i18n="Fetch Nimbus Shipments">Fetch Nimbus Shipments</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <a href="{{ route('orders.ShiprocketShipment') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-settings"></i>

                <div data-i18n="Fetch Shiprocket Shipments">Fetch Shiprocket Shipments</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <a href="{{ route('admin.contact.index') }}" class="menu-link">
               <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>


                <div data-i18n="Contacts">Inquaries</div>
            </a>
        </li>

    </ul>
</aside>
