@extends('layouts.master')

@section('title')
Edit booking
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Edit booking</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/booking/list')}}">Bookings</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Edit booking</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit booking</h3>
            </div>
            <div class="card-body">
                <form id="update_form">
                    @csrf
                    <input type="hidden" name="id" id="{{$booking->id}}" value="{{$booking->id}}">
                    <div class="row">

                        <div class="form-group col-lg-6 col-sm-6">
                            <label class="form-label mb-0">Change Status: <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="">choose status</option>
                                <option value="new" {{$booking->status == 'new' ? 'selected' : ''}}>New</option>
                                <option value="cancelled" {{$booking->status == 'cancelled' ? 'selected' : ''}}>Cancelled</option>                              
                                <option value="completed" {{$booking->status == 'completed' ? 'selected' : ''}}>Completed</option>                             
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-sm-6 text-left">
                            <label class="form-label mb-0">Save Changes</label>
                            <button type="submit" class="btn btn-primary btnSubmit" id="btnSubmit">
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
                url: '/api/booking/update',
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
