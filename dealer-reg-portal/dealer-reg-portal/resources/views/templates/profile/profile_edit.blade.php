@extends('layouts.master')

@section('title')
Edit Profile
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Edit Profile</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/profile')}}">Profile</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <!-- <div class="text-end pt-2 px-3">
                    <a role="button" class="btn btn-dealer" href="{{url('/user/add')}}">
                        <span class="fe fe-edit fs-14"></span> Edit profile</a>
                </div> -->
                <!-- <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>
                </div> -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-12 col-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Change Image</div>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center chat-image mb-5">
                                                <div class="avatar avatar-xxl chat-profile mb-3 brround">
                                                    @if(Auth::user()->photo==NULL)
                                                    <img id="user_photo_selected" alt="avatar"
                                                        src="{{asset('assets/images/users/avatar-121.png')}}"
                                                        class="brround"></a>

                                                    @else
                                                    <img id="user_photo_selected"
                                                        src="{{asset('/uploads/files/'.Auth::user()->photo)}}" alt=""
                                                        class="brround">
                                                    @endif
                                                </div>

                                                <div class="main-chat-msg-name">
                                                    <h5 class="mb-1 text-dark fw-semibold">
                                                        {{ucwords(Auth::user()->first_name) }}
                                                        {{ ucwords(Auth::user()->last_name)  }}</h5>

                                                    <!-- <p class="text-muted mt-0 mb-0 pt-0 fs-13">Web Designer</p> -->
                                                </div>
                                            </div>
                                            <form id="photo_upload">
                                                <div class="col-12">
                                                    <input type="file" class="form-control imageChange" accept="image/*"
                                                        required id="imageChange" name="photo" id="photo">

                                                </div>
                                                <div id="photo-error" class="text-muted small mt-1 text-center">
                                                    Allowed JPG, GIF or PNG. Max size of 2MB
                                                </div>
                                                <div class="text-center mt-2">
                                                    <button type="submit" class="btn btn-dealer btnSubmit"
                                                        id="btnSubmit"> <i class="fa fa-spinner fa-pulse" id="fa-pulse"
                                                            style="display: none;"></i>
                                                        Change photo</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Edit Password</div>
                                        </div>
                                        <div class="card-body">
                                            <form id="change_password">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="form-label">Current Password</label>
                                                    <div class="wrap-input100 validate-input input-group"
                                                        id="Password-toggle">
                                                        <a href="javascript:void(0)"
                                                            class="input-group-text bg-white text-muted">
                                                            <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                        </a>
                                                        <input class="input100 form-control" type="password" required
                                                            name="current_password" placeholder="Current Password">
                                                    </div>
                                                    <!-- <input type="password" class="form-control" value="password"> -->
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">New Password</label>
                                                    <div class="wrap-input100 validate-input input-group"
                                                        id="Password-toggle1">
                                                        <a href="javascript:void(0)"
                                                            class="input-group-text bg-white text-muted">
                                                            <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                        </a>
                                                        <input class="input100 form-control" type="password" required
                                                            name="new_password" placeholder="New Password">
                                                    </div>
                                                    <!-- <input type="password" class="form-control" value="password"> -->
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Confirm Password</label>
                                                    <div class="wrap-input100 validate-input input-group"
                                                        id="Password-toggle2">
                                                        <a href="javascript:void(0)"
                                                            class="input-group-text bg-white text-muted">
                                                            <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                        </a>
                                                        <input class="input100 form-control" type="password" required
                                                            name="confirm_password" placeholder="Confirm Password">
                                                    </div>
                                                    <!-- <input type="password" class="form-control" value="password"> -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-center pb-3">
                                                        <button type="submit" id="btnSubmitPassword"
                                                            class="btn btn-dealer px-4">
                                                            <i class="fa fa-spin fa-spinner" id="bx-pass"
                                                                style="display: none"></i> Save Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row col-xl-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Profile</h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="update_profile">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">Dealership or Organization name
                                                            :</label>
                                                        <input type="text" class="form-control" id=""
                                                            name="dealership_name"
                                                            value="{{ucwords(Auth::user()->dealership_name) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <label class="form-label mb-0">First name :</label>
                                                    <input type="text" class="form-control" id="" name="first_name"
                                                        value="{{ucwords(Auth::user()->first_name) }}">
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <label class="form-label mb-0">Last name :</label>
                                                    <input type="text" class="form-control" id="" name="last_name"
                                                        value="{{ ucwords(Auth::user()->last_name) }}">
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="" class="form-label mb-0">Address :</label>
                                                        <textarea name="" id="" cols="30" rows="3" class="form-control" name="address"
                                                            value="{{ucwords(Auth::user()->address) }}">{{ucwords(Auth::user()->address) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">Phone number :</label>
                                                        <input type="number" class="form-control" id="" name="ph_number"
                                                            value="{{ucwords(Auth::user()->ph_number) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">Website :</label>
                                                        <input class="form-control" type="text" name="website"
                                                            value="{{ucwords(Auth::user()->website) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">Email :</label>
                                                        <input class="form-control" type="email" name="email"
                                                            value="{{ucwords(Auth::user()->email) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">Additional Contact name :</label>
                                                        <input class="form-control" type="text"
                                                            name="additional_contact_name"
                                                            value="{{ucwords(Auth::user()->additional_contact_name) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 mb-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Additional contact email :</label>
                                                        <input class="form-control" type="email"
                                                            name="additional_contact_email"
                                                            value="{{ucwords(Auth::user()->additional_contact_email) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">Additional address :</label>
                                                        <textarea name="" id="" cols="30" rows="3" class="form-control" name="additional_address"
                                                            value="{{ucwords(Auth::user()->additional_address) }}">{{ucwords(Auth::user()->additional_address) }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">Additional phone number :</label>
                                                        <input class="form-control" type="text"
                                                            name="additional_phone_number"
                                                            value="{{ucwords(Auth::user()->additional_phone_number) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">FEDEX Account :</label>
                                                        <input class="form-control" type="text" name="fedex_account"
                                                            value="{{ucwords(Auth::user()->fedex_account) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">EIN :</label>
                                                        <input class="form-control" type="text" name="ein"
                                                            value="{{ucwords(Auth::user()->ein) }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label mb-0">About us :</label>
                                                        <textarea name="" id="" cols="30" rows="3" class="form-control" name="about"
                                                            value="{{ucwords(Auth::user()->about) }}">{{ucwords(Auth::user()->about) }}</textarea>                                                       
                                                    </div>
                                                </div>
                                                <label class="form-label mb-0 mt-3">Preferred payment method</label>
                                                <div class="form-group">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="ach"
                                                            name="example-radios" value="option1">
                                                        <span class="custom-control-label form-label">ACH :</span>
                                                    </label>
                                                </div>
                                                <div class="" style="display:none" id="achshow">
                                                    <div class="col-lg-6 col-md-12 ">
                                                        <div class="form-group ">
                                                            <label class="form-label mb-0 mt-0 pt-0">Account no
                                                                :</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="account no">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label mb-0 mt-0 pt-0">Routing no
                                                                :</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="routing no">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="credit"
                                                            name="example-radios" value="option1">
                                                        <span class="custom-control-label form-label">Credit card
                                                            :</span>
                                                    </label>
                                                </div>
                                                <div class="" style="display:none" id="creditshow">
                                                    <div class="col-lg-6 col-md-12 ">
                                                        <div class="form-group ">
                                                            <label class="form-label mb-0 mt-0 pt-0">Credit card no
                                                                :</label>
                                                            <input class="form-control" type="number"
                                                                placeholder="account no">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-0 mt-0 pt-0">Expiray date
                                                                :</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="expiary date">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label mb-0 mt-0 pt-0">CSV :</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="routing no">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="mailIn"
                                                            name="example-radios" value="option1">
                                                        <span class="custom-control-label form-label">Mail in check
                                                            :</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <button type="submit" class="btn btn-dealer px-4" id="btnSubmitProfile">
                                                    <i class="fa fa-spin fa-spinner" id="profile-spin"
                                                        style="display: none"></i>
                                                    Save
                                                    Changes</button>

                                            </div>
                                        </form>
                                    </div>
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
        // photo preview
        $(document).on('change', '.imageChange', function (e) {
            // alert('hello')
            photoError = 0;
            if (e.target.files && e.target.files[0]) {
                // console.log(e.target.files[0].name.strtolower())
                if (e.target.files[0].name.match(/\.(jpg|jpeg|JPG|png|gif|PNG)$/)) {
                    $("#photo-error").empty();
                    photoError = 0;
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#user_photo_selected').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files[0]);

                } else {
                    photoError = 1;
                    $("#photo-error").empty();
                    $(".btnSubmit").prop('disabled', true);

                    $("#photo-error").append(
                        '<p class="text-danger">Please upload only jpg, png format!</p>');
                }
            } else {
                $('#user_photo_selected').attr('src', '');
            }

            if (photoError == 0) {
                $(".btn-change-photo").prop('disabled', false);
                $("#btnSubmit").attr('disabled', false);
            } else {
                $(".btn-change-photo").prop('disabled', true);
            }
        });

        $("#photo_upload").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/change/photo',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $("#fa-pulse").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $("#fa-pulse").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] === "fail") {
                        toastr.error('Failed', response["msg"]);
                    } else if (response["status"] === "success") {
                        toastr.success('Success', response["msg"]);
                        // location.href = './profile';
                    } else if (response["status"] === "error") {
                        PhotoErrorMsg(response["msg"]);
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        function PhotoErrorMsg(msg) {
            $.each(msg, function (key, value) {
                toastr.error('Failed', msg);
            });
        }


        // UpdateProfile

        $("#update_profile").on('submit', (function (e) {
            // alert('asdk');
            e.preventDefault();
            $.ajax({
                url: '/api/update/profile',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmitProfile").attr('disabled', true);
                    $("#profile-spin").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmitProfile").attr('disabled', false);
                    $("#profile-spin").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] === "fail") {
                        printErrorMsg(response["msg"]);
                    } else if (response["status"] === "success") {
                        toastr.success('Success', response["msg"]);
                        //location.reload();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        function printErrorMsg(msg) {
            $.each(msg, function (key, value) {
                toastr.error('Failed', msg);
            });
        }

        // change Password
        $("#change_password").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/change/password',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmitPassword").attr('disabled', true);
                    $("#bx-pass").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmitPassword").attr('disabled', false);
                    $("#bx-pass").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] === "fail") {
                        toastr.error('Failed', response["msg"]);
                    } else if (response["status"] === "success") {
                        toastr.success('Success', response["msg"]);
                        $("#change_password")[0].reset();
                    }

                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        function disableAlert(alr) {
            $("#" + alr).css("display", "none");
        }
    });

</script>
@endsection
