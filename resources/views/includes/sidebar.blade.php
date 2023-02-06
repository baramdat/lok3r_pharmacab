<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="#javascript:;">

                <img src="{{ asset(env('APP_LOGO')) }}" class="header-brand-img desktop-logo" alt="logo1s"
                    style="height:40px !important;">
                <img src="{{ asset(env('APP_LOGO')) }}" class="header-brand-img toggle-logo" alt="logo2s"
                    style="height:40px !important;">
                <img src="{{ asset(env('app_icon')) }}" class="header-brand-img light-logo" alt="logo3s"
                    style="height:40px !important;">
                <img src="{{ asset(env('APP_LOGO')) }}" class="header-brand-img light-logo1" alt="logo4s"
                    style="height:40px !important;">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>Main</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/dashboard') }}"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Dashboard</span></a>
                </li>

                @if (!Auth::user()->hasRole('Site User'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                class="side-menu__icon fe fe-users"></i><span class="side-menu__label">Users</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li><a href="{{ url('/user/list') }}" class="slide-item"> User list</a></li>
                            @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Site Admin'))
                                <li><a href="{{ url('/user/add') }}" class="slide-item"> User add</a></li>
                                <!-- <li><a href="{{ url('/user/role') }}" class="slide-item"> User role</a></li> -->
                            @endif

                        </ul>
                    </li>
                @endif
                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Site Admin'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                class="side-menu__icon fe fe-bar-chart-2"></i><span
                                class="side-menu__label">Sites</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li><a href="{{ url('/site/list') }}" class="slide-item"> Site list</a></li>
                            @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Site Admin'))
                                <li><a href="{{ url('/site/add') }}" class="slide-item"> Site add</a></li>
                            @endif
                            <!-- <li><a href="{{ url('/user/role') }}" class="slide-item"> User role</a></li> -->
                        </ul>
                    </li>
                @endif

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-server"></i><span class="side-menu__label">Lockers</span><i
                            class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/locker/list') }}" class="slide-item"> Lockers list</a></li>
                        @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Site Admin'))
                        <li><a href="{{ url('/locker/add') }}" class="slide-item"> Locker add</a></li>
                        @endif
                    </ul>
                </li>

                {{-- @if (Auth::user()->hasRole('Super Admin'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                class="side-menu__icon fe fe-dollar-sign"></i><span
                                class="side-menu__label">Pricing</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li><a href="{{ url('/pricing/current') }}" class="slide-item"> Current Pricing</a></li>
                            <li><a href="{{ url('/pricing/history') }}" class="slide-item"> Pricing History</a></li>
                        </ul>
                    </li>
                @endif --}}
                
{{-- 
                @if (Auth::user()->hasRole('User'))

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/pricing') }}"><i
                                class="side-menu__icon fe fe-dollar-sign"></i><span class="side-menu__label">Locker
                                Pricing</span></a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/booking/add') }}"><i
                                class="side-menu__icon fe fe-arrow-right"></i><span class="side-menu__label">Book A
                                Locker</span></a>
                                
                    </li>

                @endif --}}

                {{-- <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/booking/list') }}"><i
                            class="side-menu__icon fe fe-server"></i><span
                            class="side-menu__label">{{ Auth::user()->hasRole('Site User') ? 'Your' : '' }} Booking
                            List</span></a>
                </li> --}}

                {{-- <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/payment/list') }}"><i
                            class="side-menu__icon fe fe-dollar-sign"></i><span
                            class="side-menu__label">{{ Auth::user()->hasRole('Site User') ? 'Your' : '' }} Payments
                            List</span></a>
                </li> --}}


                <!-- <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/notification') }}"><i
                            class="side-menu__icon fe fe-bell"></i><span class="side-menu__label">Notification</span></a>
                </li> -->

                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User'))
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                class="side-menu__icon fe fe-bar-chart-2"></i><span
                                class="side-menu__label">Categories</span><i
                                class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li><a href="{{ route('category.list') }}" class="slide-item"> Categories list</a></li>
                            <li><a href="{{ route('add.categories') }}" class="slide-item"> Categories add</a></li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                                class="side-menu__icon fe fe-bar-chart-2"></i><span
                                class="side-menu__label">Products</span><i class="angle fe fe-chevron-right"></i></a>
                        <ul class="slide-menu">
                            <li><a href="{{ route('products.list') }}" class="slide-item">Products list</a></li>
                            <li><a href="{{ route('add.products') }}" class="slide-item"> Products add</a></li>
                            <li><a href="{{ url('locker/open/history') }}" class="slide-item"> Products History</a></li>
                        </ul>
                    </li>
                @endif
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ url('/profile') }}"><i
                            class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
                </li>
                <li class="slide">
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class="side-menu__icon fe fe-log-out"></i>
                            <span class="side-menu__label text-dark">{{ __('Log out') }}</span>

                        </button>
                    </form>
                </li>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
    <!--/APP-SIDEBAR-->
</div>
