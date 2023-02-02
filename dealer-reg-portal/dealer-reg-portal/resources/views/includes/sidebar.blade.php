<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
        <a class="header-brand1" href="#javascript:;">
            
                <img src="{{asset('assets/images/brand/LOGO-FINAL.JPEG')}}" class="header-brand-img desktop-logo" alt="logo1s" style="height:58px !important; width:121px !important;">
                <img src="{{asset('assets/images/brand/LOGO-FINAL.JPEG')}}" class="header-brand-img toggle-logo" alt="logo2s" style="display:none !important;">
                <img src="{{asset('assets/images/brand/LOGO-FINAL.JPEG')}}" class="header-brand-img light-logo" alt="logo3s">
                <img src="{{asset('assets/images/brand/LOGO-FINAL.JPEG')}}" class="header-brand-img light-logo1" alt="logo4s" style="height:58px !important; width:121px !important;">
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
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('/dashboard')}}"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Home</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-users"></i><span
                            class="side-menu__label">Users</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/user/list')}}" class="slide-item"> User list</a></li>
                        <li><a href="{{ url('/user/add')}}" class="slide-item"> User add</a></li>
                        <li><a href="{{ url('/user/role')}}" class="slide-item"> User role</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-server"></i><span
                            class="side-menu__label">Services</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/service/list')}}" class="slide-item"> Service list</a></li>
                        <li><a href="{{ url('/service/add')}}" class="slide-item"> Service add</a></li>
                        <li><a href="{{ url('/service/edit')}}" class="slide-item"> Service edit</a></li>
                    </ul>
                </li>
                
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('transaction/new')}}"><i
                            class="side-menu__icon fe fe-plus"></i><span class="side-menu__label">New</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('/transaction/pending')}}"><i
                            class="side-menu__icon fe fe-alert-octagon"></i><span class="side-menu__label">Pending
                            </span><span class="badge bg-pink side-badge">4</span><i
                            class="angle fe fe-chevron-right hor-angle"></i></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('/notification')}}"><i
                            class="side-menu__icon fe fe-bell"></i><span class="side-menu__label">Notification</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('transaction/completed')}}"><i
                            class="side-menu__icon fe fe-check-circle"></i><span class="side-menu__label">Completed</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('/form/list')}}"><i
                            class="side-menu__icon fe fe-file"></i><span class="side-menu__label">Forms</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('/profile')}}"><i
                            class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Profile</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{url('/contact')}}"><i
                            class="side-menu__icon fe fe-phone"></i><span class="side-menu__label">Contact</span></a>
                </li>
                <li class="slide">
                <form method="post" action="{{route('logout')}}">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i class="side-menu__icon fe fe-log-out"></i>
                                <span class="side-menu__label text-dark">{{ __('Log out') }}</span>
                                
                            </button>
                        </form>
                </li>
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>
    <!--/APP-SIDEBAR-->
</div>
