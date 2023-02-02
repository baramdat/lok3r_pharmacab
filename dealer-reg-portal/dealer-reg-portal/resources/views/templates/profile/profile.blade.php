@extends('layouts.master')

@section('title')
Profile
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Profile</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-xl-12">
            
            <div class="card">
                <div class="text-end pt-2 px-3">
                    <a role="button" class="btn btn-dealer" href="{{url('/profile/edit')}}">
                        <span class="fe fe-edit fs-14"></span> Edit profile</a>
                </div>
                <!-- <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>
                </div> -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="text-center chat-image mb-5">
                                <div class="avatar avatar-xxl chat-profile mb-3 brround">
                                    @if(Auth::user()->photo==NULL)
                                    <img id="user_photo_selected" alt="avatar"
                                        src="{{asset('assets/images/users/avatar-121.png')}}" class="brround"></a>

                                    @else
                                    <img id="user_photo_selected" src="{{asset('/uploads/files/'.Auth::user()->photo)}}"
                                        alt="" class="img-fluid rounded-circle mx-auto"
                                        style="width:140px;height:130px;object-fit:cover;">
                                    @endif
                                </div>

                                <div class="main-chat-msg-name">
                                    <h5 class="mb-1 text-dark fw-semibold">{{ucwords(Auth::user()->first_name) }}
                                        {{ ucwords(Auth::user()->last_name)  }}</h5>

                                    <!-- <p class="text-muted mt-0 mb-0 pt-0 fs-13">Web Designer</p> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">About us</label>
                                <div>
                                    <p class="text-muted">{{ucwords(Auth::user()->about) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Dealership or Organization name :</label>
                                        <input type="text" class="form-control" id="exampleInputname"
                                            value="{{ucwords(Auth::user()->dealership_name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Contact name :</label>
                                        <input type="text" class="form-control" id="exampleInputname1"
                                            value="{{ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name)  }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label mb-0">Address :</label>
                                        <input type="text" class="form-control" id=""
                                            value="{{ucwords(Auth::user()->address) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Phone number :</label>
                                        <input type="number" class="form-control" id="exampleInputnumber"
                                            value="{{ucwords(Auth::user()->ph_number) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Website :</label>
                                        <input class="form-control" type="text"
                                            value="{{ucwords(Auth::user()->website) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Email :</label>
                                        <input class="form-control" type="email"
                                            value="{{ucwords(Auth::user()->email) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Additional Contact name :</label>
                                        <input class="form-control" type="text"
                                            value="{{ucwords(Auth::user()->additional_contact_name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 mb-0">
                                    <div class="form-group">
                                        <label class="form-label">Additional contact email :</label>
                                        <input class="form-control" type="email"
                                            value="{{ucwords(Auth::user()->additional_contact_email) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Additional address :</label>
                                        <input class="form-control" type="text"
                                            value="{{ucwords(Auth::user()->additional_address) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">Additional phone number :</label>
                                        <input class="form-control" type="text"
                                            value="{{ucwords(Auth::user()->additional_phone_number) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">FEDEX Account :</label>
                                        <input class="form-control" type="text"
                                            value="{{ucwords(Auth::user()->fedex_account) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-0">EIN :</label>
                                        <input class="form-control" type="text" value="{{ucwords(Auth::user()->ein) }}">
                                    </div>
                                </div>
                                <label class="form-label mb-0 mt-3">Preferred payment method</label>
                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="ach" name="example-radios"
                                            value="option1">
                                        <span class="custom-control-label form-label">ACH :</span>
                                    </label>
                                </div>
                                <div class="" style="display:none" id="achshow">
                                    <div class="col-lg-6 col-md-12 ">
                                        <div class="form-group ">
                                            <label class="form-label mb-0 mt-0 pt-0">Account no :</label>
                                            <input class="form-control" type="text" placeholder="account no">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="form-label mb-0 mt-0 pt-0">Routing no :</label>
                                            <input class="form-control" type="text" placeholder="routing no">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="credit"
                                            name="example-radios" value="option1">
                                        <span class="custom-control-label form-label">Credit card :</span>
                                    </label>
                                </div>
                                <div class="" style="display:none" id="creditshow">
                                    <div class="col-lg-6 col-md-12 ">
                                        <div class="form-group ">
                                            <label class="form-label mb-0 mt-0 pt-0">Credit card no :</label>
                                            <input class="form-control" type="number" placeholder="account no">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label mb-0 mt-0 pt-0">Expiray date :</label>
                                            <input class="form-control" type="text" placeholder="expiary date">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label mb-0 mt-0 pt-0">CSV :</label>
                                            <input class="form-control" type="text" placeholder="routing no">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="mailIn"
                                            name="example-radios" value="option1">
                                        <span class="custom-control-label form-label">Mail in check :</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
        $("#ach").on('click', function (e) {
            $("#achshow").css('display', 'flex');
            $("#cridtshow").hide();


        })

        $("#credit").on('click', function (e) {
            $("#creditshow").css('display', 'flex');
            $("#achshow").hide();


        })

        $("#mailIn").on('click', function (e) {
            $("#creditshow").hide();

            $("#achshow").hide();


        })
    })

</script>

@endsection
