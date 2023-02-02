@extends('layouts.master')

@section('title')
    Add Product
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">


        <!-- PAGE-HEADER Breadcrumbs-->
        <div class="page-header">
            <h1 class="page-title">Add Product</h1>
            <div>
                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a> </li>
                    <li class="breadcrumb-item"><a href="{{ url('/site/list') }}">Product List</a> </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Product</li>

                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Product</h3>
                </div>
                <div class="card-body">
                    <form id="add_form">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6 col-sm-12">
                                <label class="form-label mb-0">Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Product name.." required>
                            </div>

                            <div class="form-group col-lg-6 col-sm-12">
                                <label class="form-label mb-0">Unit:</label>
                                <input type="text" class="form-control" id="unit" name="unit"
                                    placeholder="Product unit..">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label class="form-label mb-0">Quantity: <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    placeholder="Product quantity.." required>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label class="form-label mb-0">Parent Category: <span class="text-danger">*</span></label>
                                {{-- <input type="text" class="form-control" id="url" name="url" placeholder="URL.." required> --}}
                                <select class="form-select" name="parent" id="parent" required>
                                    <option value="">Select parent :</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label class="form-label mb-0">Child Category: </label>
                                <select class="form-select" name="child" id="child" >
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
        $(document).ready(function(e) {
            // add forms
            $("#add_form").on('submit', (function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('/api/product/add') }}",
                    type: "POST",
                    data: new FormData(this),
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $("#btnSubmit").attr('disabled', true);
                        $(".fa-pulse").css('display', 'inline-block');
                    },
                    complete: function() {
                        $("#btnSubmit").attr('disabled', false);
                        $(".fa-pulse").css('display', 'none');
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response["status"] == "fail") {
                            toastr.error('Failed', response["msg"])
                        } else if (response["status"] == "success") {
                            toastr.success('Success', response["msg"])
                            $("#add_form")[0].reset();
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });

            }));

            $('#parent').on('change', function(e) {
                var id = $('#parent').val();
                $.ajax({
                    url: "{{ url('get/child/category') }}",
                    type: "get",
                    data: {id:id},
                    dataType: "JSON",
                    cache: false,
                    success: function(response) {
                        // console.log(response);
                        if (response["status"] == "fail") {
                            toastr.error('Failed', response["msg"])
                        } else if (response["status"] == "success") {
                            $("#child").html('');
                           $('#child').append(response["rows"]);
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });
                
            })
        });
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
