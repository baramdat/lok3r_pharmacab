@extends('layouts.master')

@section('title')
Edit category
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Edit Category</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/category/list')}}">Categories</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Categories</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Categories</h3>
            </div>
            <div class="card-body">
                <form id="update_form">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{$category->id}}">
                    <div class="row">
                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Title: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Category title.." value="{{$category->title}}" required>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Site Address: <span class="text-danger">*</span></label>
                            <select class="form-select" name="parent" id="parent" value="{{$category->parent_id}}">
                                <option value="">Select parent :</option>
                            @foreach($categories as $categry)
                            <option value="{{$categry->id}}" {{$categry->id==$category->parent_id?'selected':''}}>{{$categry->title}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group col-lg-12 col-sm-12 text-center">
                            <button type="submit" class="btn btn-dealer btnSubmit" id="btnSubmit">
                                <i class="fa fa-spinner fa-pulse" style="display: none;"></i>
                            Save</button>
                        </div>                        
                    </div>                
                </form>
            </div>
        </div>
    </div>

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //DropZone
    Dropzone.autoDiscover = false;
    $(document).ready(function () {

        $("#btnSubmit").on('click', (function (e) {
            $("#update_form").submit()
        }));

        $("#update_form").on('submit', (function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '/api/category/update',
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-spinner").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-spinner").css('display', 'none');
                }, 
                success: function (response) {
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
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
