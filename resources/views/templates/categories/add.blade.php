@extends('layouts.master')

@section('title')
Add Category
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Add Category</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/site/list')}}">Categories List</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Add Category</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Category</h3>
            </div>
            <div class="card-body">
                <form id="add_form">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Title: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Category title.." required>
                        </div>

                        {{-- <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Slug: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Category slug.." required>
                        </div> --}}

                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Type: </label>
                            <select class="form-select" name="parent" id="parent">
                                <option value="">Select parent :</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>
                        </div>

                        <div class="form-group col-lg-12 col-sm-12 text-center">
                            <button type="submit" class="btn btn-dealer w-25 btnSubmit" id="btnSubmit"> 
                                <i class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                Save
                            </button>
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
<script>
    $(document).ready(function (e) {
        // add forms
        $("#add_form").on('submit', (function (e) {
            e.preventDefault();
                $.ajax({
                    url: "{{url('/api/category/add')}}",
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
                            $("#add_form")[0].reset();
                        }
                    },
                    error: function (error) {
                        // console.log(error);
                    }
                });
            
        }));

        
    });

</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
