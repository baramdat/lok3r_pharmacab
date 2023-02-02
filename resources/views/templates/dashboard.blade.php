@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('content')

@php
use \App\Http\Controllers\BookingController;
@endphp
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Dashboard {{env('APP_LOGO')}}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-12 mb-3">
            Hello {{Auth::user()->first_name}} | <small class="badge bg-success">{{ucwords(Auth::user()->roles->pluck('name')[0])}}</small>
            <?php
            if(Auth::user()->site_id != ''){
                echo '| <i class="fa fa-map-marker"></i> '.Auth::user()->site->name;
            }
            ?>
        </div>

        {{-- @if(Auth::user()->hasRole('User'))
        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Your Recent Lockers | <a href="{{url('/booking/list')}}">View All</a></h4>
                            <h6 class="mb-0 mt-3 text-muted">List of your recent lockers.</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4"
                    style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        @if(Auth::user()->hasRole('User'))
                            <?php
                            $bookingsArr = \App\Models\Booking::where('user_id',Auth::user()->id)->take(5)->skip(0)->orderBy('id','DESC')->get();
                            ?>
                            @if(sizeof($bookingsArr) > 0)
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">

                                            <tbody>
                                                @foreach($bookingsArr as $key => $booking)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{ucwords($booking->locker->number)}}</td>
                                                    <td>
                                                        <a href="{{url('/booking/details/'.$booking->id)}}">View</a>
                                                    </td>
                                                    <td>
                                                        <div class="mt-sm-1 d-block text-end">
                                                        <?=BookingController::status($booking->status)?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Your Recent Payment | <a href="{{url('/payment/list')}}">View All</a></h4>
                            <h6 class="mb-0 mt-3 text-muted">List of your recent payments.</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4"
                    style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        @if(Auth::user()->hasRole('Site User'))
                            <?php
                            $payments = \App\Models\Payment::where('user_id',Auth::user()->id)->take(5)->skip(0)->orderBy('id','DESC')->get();
                            ?>
                            @if(sizeof($payments) > 0)
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">

                                            <tbody>
                                                @foreach($payments as $key => $payment)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>${{$payment->amount}}</td>
                                                    <td>
                                                        <a target="_blank" href="{{$payment->receipt_url}}">View Receipt</a>
                                                    </td>
                                                    <td>
                                                        <div class="mt-sm-1 d-block text-end">
                                                        <?=BookingController::status($payment->status)?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                    </div>

                </div>
            </div>
        </div>
        @endif --}}

        @if(!Auth::user()->hasRole('User'))
        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Lockers Statistics</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4"
                    style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover mb-0">

                                    <tbody>
                                        <tr>
                                            <td><b>Occupired Lockers</b></td>
                                            <td>
                                                <badge class="badge bg-warning p-2">
                                                <?php
                                                $count = 
                                                \App\Models\Locker::where('occupied_by',
                                                '!=',0)->count();
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count = \App\Models\Locker::where('occupied_by',
                                                    '!=',0)->where('site_id',Auth::user()->site->id)->count();
                                                }
                                                echo $count; ?> Lockers
                                                </badge>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Available Lockers</b></td>
                                            <td>
                                                <badge class="badge bg-success p-2">
                                                <?php
                                                $count = 
                                                \App\Models\Locker::where('occupied_by',
                                                '!=',0)->count();
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count = \App\Models\Locker::where('status','available')->where('site_id',Auth::user()->site->id)->count();
                                                }
                                                echo $count; ?> Lockers

                                                </badge>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Inactive Lockers</b></td>
                                            <td>
                                                <badge class="badge bg-danger p-2">
                                                <?php
                                                $count = 
                                                \App\Models\Locker::where('occupied_by',
                                                '!=',0)->count();
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count = \App\Models\Locker::where('status',
                                                    'inactive')->where('site_id',Auth::user()->site->id)->count();
                                                }
                                                echo $count; ?> Lockers
                                                </badge>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Total Lockers</b></td>
                                            <td>
                                                <badge class="badge bg-info p-2">
                                                <?php
                                                $count = 
                                                \App\Models\Locker::count();
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count = \App\Models\Locker::where('site_id',Auth::user()->site->id)->count();
                                                }
                                                echo $count; ?> Lockers
                                                </badge>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Users Statistics</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4"
                    style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover mb-0">

                                    <tbody>
                                        <tr>
                                            <td><b>Currently Using Lockers</b></td>
                                            <td>
                                                <badge class="badge bg-warning p-2">
                                                <?php
                                                $count = 
                                                \App\Models\Locker::select('user_id')->distinct()->where('occupied_by',
                                                '!=',0)->count();
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count = \App\Models\Locker::select('user_id')->distinct()->where('occupied_by',
                                                    '!=',0)->where('site_id',Auth::user()->site->id)->count();
                                                }
                                                echo $count; ?> Users

                                                </badge>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Currently Not Using Lockers</b></td>
                                            <td>
                                                <badge class="badge bg-success p-2">
                                                <?php
                                                $totalUsing = \App\Models\Locker::select('user_id')->distinct()->where('occupied_by',
                                                '!=',0)->count();

                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count = \App\Models\Locker::select('user_id')->distinct()->where('occupied_by',
                                                    '!=',0)->where('site_id',Auth::user()->site->id)->count();
                                                }

                                                $notUsing = \App\Models\User::count() - $totalUsing;
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $notUsing = \App\Models\User::where('site_id',Auth::user()->site->id)->count() - $totalUsing;
                                                }
                                                echo $notUsing;
                                                ?> Users

                                                </badge>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Banned Users</b></td>
                                            <td>
                                                <badge class="badge bg-danger p-2">
                                                <?php
                                                $count = \App\Models\User::where('status',
                                                2)->count();
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count = \App\Models\User::where('status',
                                                    2)->where('site_id',Auth::user()->site->id)->count();
                                                }
                                                echo $count; ?> Users
                                                </badge>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Total Users</b></td>
                                            <td>
                                                <badge class="badge bg-info p-2">
                                                <?php
                                                $count = \App\Models\User::count();
                                                if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Site User')){
                                                    $count =\App\Models\User::where('site_id',Auth::user()->site->id)->count();
                                                }
                                                echo $count; ?> Users

                                                </badge>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Pricing Statistics</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4"
                    style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <?php
                    $sizesArr = App\Models\LockerSize::all();
                    ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover mb-0">

                                    <tbody>
                                        @foreach ($sizesArr as $size)
                                        <tr>
                                            <td><b>{{$size->size}} Size Lockers</b></td>
                                            <td>
                                                <h6>${{$size->hourly}}/Hour</b><h6>
                                                <badge class="badge bg-default">Rented <?=\App\Models\Booking::where('size_id',$size->id)->where('duration','hourly')->count()?> times</badge>
                                            </td>
                                            <td>
                                                <h6>${{$size->daily}}/Day</b><h6>
                                                <badge class="badge bg-default">Rented <?=\App\Models\Booking::where('size_id',$size->id)->where('duration','daily')->count()?> times</badge>
                                            </td>
                                            <td>
                                                <h6>${{$size->monthly}}/Month</b><h6>
                                                <badge class="badge bg-default">Rented <?=\App\Models\Booking::where('size_id',$size->id)->where('duration','monthly')->count()?> times</badge>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Locker History</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4"
                    style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover mb-0">
                                    <thead>
                                        <th>User Name</th>
                                        <th>Product</th>
                                        <th>Site</th>
                                        <th>Locker Number</th>
                                        <th>Quantity</th>
                                        <th>Opening Reason</th>
                                        <th>Opening Date</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($locker_history as $locker)
                                        <tr>
                                            <td>{{ucwords($locker->user->first_name)}} {{$locker->user->last_name}}</td>
                                            <td><a href="{{url('products/list')}}?id={{$locker->item_id}}">{{ucwords($locker->inventory_item->name)}}</a></td>
                                            <td>{{ucwords($locker->site->name)}}</td>
                                            <td>{{$locker->locker->number}}</td>
                                            <td>{{$locker->quantity}}</td>
                                            <td>{{$locker->notes}}</td>
                                            <td>{{ date_format($locker->created_at, 'M d ,Y  H:i A') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a  href="{{route('locker.opening.history')}}" class="btn btn-info btn-sm pull-right mt-3">View All</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- ROW-1 END -->

</div>
<!-- CONTAINER END -->
@endsection
