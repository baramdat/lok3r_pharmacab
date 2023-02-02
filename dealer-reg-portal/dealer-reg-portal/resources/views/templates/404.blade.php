@extends('layouts.master')

@section('title')
User add
@endsection

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">User Add</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/user/list')}}">User list</a></li>
                <li class="breadcrumb-item active" aria-current="page">User add</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" id="add_user">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname" class="form-label mb-0">First name: <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required
                                        placeholder="First name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname1" class="form-label mb-0">Last name: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" required name="last_name"
                                        placeholder="Enter last name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <?php
                                $roles = \Spatie\Permission\Models\Role::all(); 
                            ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label mb-0">Role: <span
                                            class="text-danger">*</span></label>

                                    <select class="form-control form-select select-op" id="role" name="role" required>
                                        <option selected disabled>choose role</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label mb-0">Email address: <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required id="email"
                                        placeholder="Email address">
                                </div>
                            </div>
                            <div class="col-lg-4"> 
                                <div class="form-group">
                                    <label for="exampleInputnumber" class="mb-0 form-label">Phone number: </label>
                                    <input type="number" class="form-control" name="ph_number" id="ph_number"
                                        placeholder="Phone number">
                                </div>
                            </div>
                            

 
                        </div>
                        
                        <div class="row ">
                        <div class="col-lg-3">
                                <label class="form-label mb-0">Country: </label>
                                <select class="form-control form-select" id="country" name="country">
                                    <option selected disabled>choose country</option>
                                    <option value="">...</option>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label class="form-label mb-0">State:</label>
                                    <input type="text" class="form-control" id="state" name="state" placeholder="Enter state">
                                </select>
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label class="form-label mb-0">City: </label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                            </div>
                            <div class="col-lg-3 mb-2">
                                <label class="form-label mb-0">Zip: </label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Enter zip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label mb-0">Address: <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="address"
                                placeholder="Enter complete address"></textarea>
                        </div>
                        <!-- <div class="row mt-2">
                            <div class="col-lg-6 col-form-label">
                                <div class="col-12 text-center">
                                    <img id="user_photo_selected" src="{{asset('assets/images/users/avatar-121.png')}}"
                                        class="img-fluid rounded-circle mx-auto"
                                        style="width:140px;height:130px;object-fit:cover; " alt="user image">

                                </div>
                                <div id="photo-error" class="text-muted small mt-1 text-center">
                                    Allowed JPG, GIF or PNG. Max size of 2MB
                                </div>

                                <div class="col-12">
                                    <label class="col-form-label" for="">Image</label>
                                    <input type="file" class="form-control imageChange" accept="image/*" required
                                        id="imageChange" name="image">

                                </div>
                            </div>
                        </div> -->
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-dealer btnSubmit" id="btnSubmit"> <i
                                    class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                Save</button>
                            <!-- <input type="button" class="btn btn-danger my-1" value="Cancel"> -->
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
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

        // add user
        $("#add_user").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/add/user',
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
                        $("#add_user")[0].reset();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        $(document).on('change', '.select-op', function(e) {
            currTrigger = $("#role").find(':selected').text();
            if(currTrigger == 'Admin'){
                $("#user_type_col").hide();

            }else{
                $("#user_type_col").show();

            }

        });

    });

</script>
 
@endsection
