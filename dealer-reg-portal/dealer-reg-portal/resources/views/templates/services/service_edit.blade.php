@extends('layouts.master')

@section('title')
Service edit
@endsection

@section('content')
<style>
    .detail:hover {
        cursor: pointer;
        color: blue;
    }

</style>
<!-- CONTAINER -->
<div class="main-container container-fluid">
    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Service edit </h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/service/list')}}">Service list</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Service edit</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- ROW -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="" id="update_service">
                        @csrf
                        <input type="hidden" id="{{$service->id}}" name="id" value="{{$service->id}}">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputname" class="form-label mb-0">Service name: <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="service_name" name="service_name"
                                        required value="{{$service->service_name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label mb-0">Status:</label>
                                    <select class="form-control form-select" name="status">
                                        <option selected disabled>choose status</option>
                                        <option value="1" {{$service->status == '1' ? 'selected' :''}}>Active</option>
                                        <option value="2" {{$service->status == '2' ? 'selected' :''}}>Decline </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label mb-0">Description : </label>
                                <textarea class="form-control" rows="3" id="description" name="description"
                                    value="{{$service->description}}">{{$service->description}}</textarea>
                            </div>
                            <div class="mt-2">
                                <div class="col-lg-6 col-form-label">
                                    <div class="col-12 text-center">
                                        @if($service->photo==NULL)
                                        <img id="user_photo_selected"
                                            src="{{asset('assets/images/users/avatar-121.png')}}" alt=""
                                            class="img-fluid rounded-circle mx-auto"
                                            style="width:140px;height:130px;object-fit:cover; ">
                                        @else
                                        <img id="user_photo_selected" src="{{asset('/uploads/files/'.$service->photo)}}"
                                            alt="" class="img-fluid rounded-circle mx-auto"
                                            style="width:140px;height:130px;object-fit:cover; ">
                                        @endif

                                    </div>
                                    <div id="photo-error" class="text-muted small mt-1 text-center">
                                        Allowed JPG, GIF or PNG. Max size of 2MB
                                    </div>

                                    <div class="col-12">
                                        <label class="col-form-label" for="">Image</label>
                                        <input type="file" class="form-control imageChange" accept="image/*" required
                                            id="imageChange" name="photo">

                                    </div>
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
<!-- CONTAINER END -->
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


        // update service
        $("#update_service").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/update/service',
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
                        window.location.href= "{{'/service/list'}}";
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));

        
    });

</script>
@endsection
