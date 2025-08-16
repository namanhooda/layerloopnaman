<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ti tabler-menu-2 icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper px-md-0 px-2 mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
                </a>
            </div>
        </div>

        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">

            @include('admin.partial.navPartials.language')
            
            <!--/ Language -->

            <!-- Style Switcher -->
            @include('admin.partial.navPartials.style')
            <!-- / Style Switcher-->

            <!-- Quick links  -->
            @include('admin.partial.navPartials.links')
            <!-- Quick links -->

            <!-- Notification -->
            @include('admin.partial.navPartials.notification')
            <!--/ Notification -->

            <!-- User -->
            @include('admin.partial.navPartials.user')
            <!--/ User -->
        </ul>
    </div>
</nav>
