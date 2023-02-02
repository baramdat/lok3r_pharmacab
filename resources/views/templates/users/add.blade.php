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
                                $rolesArr = \Spatie\Permission\Models\Role::all(); 
                                if(Auth::user()->hasRole('Super Admin')){
                                    $rolesArr = \Spatie\Permission\Models\Role::where('id',2)->orWhere('id',3)->get(); 
                                }

                                if(Auth::user()->hasRole('Site Admin')){
                                    $rolesArr = \Spatie\Permission\Models\Role::where('id',3)->get(); 
                                }
                            ?>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label mb-0">Role: <span
                                            class="text-danger">*</span></label>

                                    <select class="form-control form-select {{Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff') ? '' : 'role'}}" id="role" name="role" required>
                                        <option value="">choose role</option>
                                        @foreach($rolesArr as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            
                            <?php
                                $sitesArr = \App\Models\Site::all();
                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                                    $sitesArr = \App\Models\Site::where('id',Auth::user()->site->id)->get();
                                }
                            ?>
                            <div class="col-lg-6" id="divSiteId" style="display:{{Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff') ? 'block' : 'none'}};">
                                <div class="form-group">
                                    <label class="form-label mb-0">Site:</label>

                                    <select class="form-control form-select" id="site_id" name="site_id" {{Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff') ? 'required' : ''}}>
                                        <option value="">choose site</option>
                                        @foreach($sitesArr as $site)
                                            <option value="{{$site->id}}" {{Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff') ? 'selected' : ''}}>{{ucwords($site->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label mb-0">Email address: <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required id="email"
                                        placeholder="Email address">
                                </div>
                            </div>
                        </div>
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
                url: '/api/user/add',
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
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"]) 
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $("#add_user")[0].reset();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }));

        $(".role").on('change',function(e){
            if($(this).val() == 1 || $(this).val() == 2 || $(this).val() == 3){
                $("#divSiteId").css('display','block')
                $("#site_id").attr('required',true)
            }else{
                $("#divSiteId").css('display','none')
                $("#site_id").attr('required',false)
            }
        })

    });

</script>
 
@endsection
