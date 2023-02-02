@extends('layouts.master')

@section('title')
Pricing History Details
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Pricing History Details</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/pricing/history')}}">Pricing History</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Pricing History Details</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pricing on <?=date('m/d/Y',strtotime($pricingHistory["date"]))?></h3>
            </div>
            <div class="card-body">
                <form id="pricing_form">
                    @csrf
                    <?php
                    $sizesArr = App\Models\LockerSize::all();  
                    $historyArr = json_decode($pricingHistory["history"]);
                    $hourly = 30;
                    $daily = 0;
                    $monthly = 0;                         
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
                                            @foreach ($historyArr as $history)
                                                @if($history->size_id == $size->id)
                                                    <?php $hourly = $size->hourly; ?>
                                                    <?php $daily = $size->daily; ?>
                                                    <?php $monthly = $size->monthly; ?>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <th>
                                                    {{$size->size}}
                                                </th>
                                                <td>
                                                    {{$hourly}}                
                                                </td>
                                                <td>
                                                    {{$daily}}                 
                                                </td>
                                                <td>
                                                    {{$monthly}}                 
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group col-lg-12 col-sm-12 text-left">
                            <a href="{{url('/pricing/history')}}" class="btn btn-dealer w-25"> 
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
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
                        $("#pricing_form")[0].reset();
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
