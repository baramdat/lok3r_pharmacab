@extends('layouts.master')

@section('title')
Current Pricing
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Current Pricing</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/pricing')}}">Pricing</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Current Pricing</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Pricing</h3>
            </div>
            <div class="card-body">
                <form id="pricing_form">
                    @csrf
                    <?php
                    $sizesArr = App\Models\LockerSize::all();                            
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Locker Size</th>
                                            <th>Per Hour ($)</th>
                                            <th>Per Day ($)</th>
                                            <th>Per Month ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sizesArr as $size)
                                            <tr>
                                                <th>
                                                    {{$size->size}}

                                                    <input type="hidden" class="form-control form-control-sm w-50" id="size_id{{$size->id}}" name="size_id[]" min="1" placeholder="" value="{{$size->id}}" required>
                                                </th>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm w-50" id="hourly{{$size->id}}" name="hourly[]" min="1" placeholder="" value="{{$size->hourly}}" required>                 
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm w-50" id="daily{{$size->id}}" name="daily[]" min="1" placeholder="" value="{{$size->daily}}" required>                 
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm w-50" id="monthly{{$size->id}}" name="monthly[]" min="1" placeholder="" value="{{$size->monthly}}" required>                 
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
        $("#pricing_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/pricing/update',
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
