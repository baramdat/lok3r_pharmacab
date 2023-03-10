@extends('layouts.master')

@section('title')
User edit
@endsection

@section('content')
<div class="main-container container-fluid">
    <style>
        #user_photo_selected {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">User Edit</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/user/list')}}">User list</a></li>
                <li class="breadcrumb-item active" aria-current="page">User edit</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="row">
        <div class="col-lg-12"> 
            <div class="card">
                <div class="card-body">
                    <form action="" id="update_user">
                        @csrf
                        <input type="hidden" id="{{$user->id}}" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname" class="form-label mb-0">First name: <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="exampleInputname" name="first_name"
                                        required value="{{$user->first_name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname1" class="form-label mb-0">Last name: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="exampleInputname1" required
                                        name="last_name" value="{{$user->last_name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label mb-0">Email address: <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                        value="{{$user->email}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputnumber" class="mb-0 form-label">Phone number: </label>
                                    <input type="number" class="form-control" name="ph_number" id="exampleInputnumber"
                                        value="{{$user->ph_number}}">
                                </div>
                            </div> 

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                    $rolesArr = \Spatie\Permission\Models\Role::all(); 
                                    if(Auth::user()->hasRole('Site Admin')){
                                        $rolesArr = \Spatie\Permission\Models\Role::where('id',1)->orWhere('id',2)->orWhere('id',3)->get(); 
                                    }
    
                                    if(Auth::user()->hasRole('Staff')){
                                        $rolesArr = \Spatie\Permission\Models\Role::where('id',3)->get(); 
                                    }
                                ?>
                                <div class="form-group">
                                    <label for="inputState" class="form-label mb-0">Role</label>
                                    <select id="inputState" class="form-select role" id="role" name="role" required>
                                        @foreach($rolesArr as $role)
                                        <option value="{{$role->id}}" {{$user->hasRole($role) ? 'selected':''}}>
                                            {{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label mb-0">Status:</label>
                                    <select class="form-control form-select" name="status">
                                        <option selected disabled>choose status</option>
                                        <option value="1" {{$user->status == '1' ? 'selected' :''}}>Active</option>
                                        <option value="2" {{$user->status == '2' ? 'selected' :''}}>Blocked </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-lg-6 col-form-label">
                                <div class="col-12 text-center">
                                    @if($user->photo==NULL)
                                    <img id="user_photo_selected" src="{{asset('assets/images/users/avatar-121.png')}}"
                                        alt="" class="img-fluid rounded-circle mx-auto">
                                    @else
                                    <img id="user_photo_selected" src="{{asset('/uploads/files/'.$user->photo)}}" alt=""
                                        class="img-fluid rounded-circle mx-auto">
                                    @endif

                                </div>
                                <div id="photo-error" class="text-muted small mt-1 text-center">
                                    Allowed JPG, GIF or PNG. Max size of 2MB
                                </div>

                                <div class="col-12">
                                    <label class="col-form-label" for="">Image</label>
                                    <input type="file" class="form-control imageChange" accept="image/*"
                                        id="imageChange" name="photo">

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-dealer btnSubmit" id="btnSubmit"> <i
                                    class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- ROW -->

    <!-- ROW END -->

</div>
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
        $(document).on('change', '.imageChange', function (e) {
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


        // update user
        $("#update_user").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/user/update',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-pulse").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-pulse").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        // $("#update_user")[0].reset();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        $(document).on('change', '.role', function (e) {
            currTrigger = $(this).find(':selected').text().trim();
            if (currTrigger == 'Admin') {
                $("#user_type_col").hide();
                $("#user_type_other").hide();
            } else {
                $("#user_type_col").show();
            }

        });
    });

</script>
@endsection
