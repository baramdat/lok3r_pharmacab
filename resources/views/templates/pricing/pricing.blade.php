@extends('layouts.master')

@section('title')
Locker Pricing
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">
    <style>
        /* Container holding the image and the text */
        .size-container {
            position: relative;
            text-align: center;
            color: white;
        }

        /* Bottom left text */
        .bottom-left {
            position: absolute;
            bottom: 8px;
            left: 16px;
        }

        /* Top left text */
        .top-left {
            position: absolute;
            top: 8px;
            left: 16px;
        }

        /* Top right text */
        .top-right {
            position: absolute;
            top: 8px;
            right: 16px;
        }

        /* Bottom right text */
        .bottom-right {
            position: absolute;
            bottom: 8px;
            right: 16px;
        }

        /* Centered text */
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Locker Pricing</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Locker Pricing</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Locker Pricing</h3>
            </div>
            <div class="card-body">
                <?php
                $sizesArr = App\Models\LockerSize::all();                            
                ?>
                <div class="row">
                    <!-- <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-4 bg-primary text-white">
                                                <p class="text-uppercase">small</p>
                                            </div>
                                            <div class="col-lg-4 bg-primary text-white">

                                            </div>
                                            <div class="col-lg-4 bg-primary text-white">

                                            </div>
                                        </div>
                                    </td>
                                    <td>Col2</td>
                                    <td>Col3</td>
                                    <td>Col4</td>
                                </tr>
                            </table>
                        </div>
                    </div> -->
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
                                            </th>
                                            <td>   
                                                {{$size->hourly}}           
                                            </td>
                                            <td> 
                                                {{$size->daily}}               
                                            </td>
                                            <td> 
                                                {{$size->monthly}}               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    <div class="col-lg-12">
                        <p>
                            <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-info text-info"></i> View Lockers Size Chart
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>S</td>
                                            <td>M</td>
                                            <td>L</td>
                                            <td>XL</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="size-container bg-info" style="height: 125px;width:100%;">
                                                    <div class="centered">
                                                        <h5>Small</h5>
                                                        <small><b>29H x 29W X 12D</b></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="size-container bg-info" style="height: 185px;width:100%;">
                                                    <div class="centered">
                                                        <h4>Medium</h4>
                                                        <small><b>28H x 32W X 18D</b></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="size-container bg-info" style="height: 275px;width:100%;">
                                                    <div class="centered">
                                                        <h4>Large</h4>
                                                        <small><b>72H x 30W X 18D</b></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="size-container bg-info" style="height: 325px;width:100%;">
                                                    <div class="centered">
                                                        <h4>Ex Large</h4>
                                                        <small><b>46"H x 72W X 18D</b></small>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-sm-12 text-center">
                        <a href="{{url('/booking/add')}}" class="btn btn-primary w-25"> 
                            <i class="fe fe-check-circle"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
    });

</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
