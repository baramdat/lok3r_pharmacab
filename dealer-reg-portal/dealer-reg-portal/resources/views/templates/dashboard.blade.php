@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
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
        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header ">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Peter Hill</h4>
                            <h6 class="mb-0 mt-3 text-muted">Transaction in progress</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3 px-4"
                    style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table  text-nowrap text-sm-nowrap table-hover mb-0">

                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Joan Powell</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Inprogress
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Gavin Gibson</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Inprogress
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Julian Kerr</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Inprogress
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Cedric Kelly</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Inprogress
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Samantha May</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Inprogress
                                                        </span>
                                                    </div>
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
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header border-bottom">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Latest Submitted Transaction</h4>
                            <!-- <small class="text-muted">just now</small> -->
                        </div>

                    </div>
                </div>
                <div class="card-body py-3 px-4"
                    style="max-height: 323px; overflow-y: scroll;   scrollbar-width: none;">

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table text-nowrap text-md-nowrap table-hover mb-0">

                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Joan Powell</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3">New
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Gavin Gibson</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Julian Kerr</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3">New
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Cedric Kelly</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Samantha May</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span
                                                            class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Inprogress
                                                        </span>
                                                    </div>
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
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card border p-0 overflow-hidden shadow-none">
                <div class="card-header border-bottom">
                    <div class="media mt-0">
                        <div class="media-body">
                            <h4 class="mb-0 mt-1">Latest communication </h4>
                            <!-- <small class="text-muted">just now</small> -->
                        </div>

                    </div>
                </div>
                <div class="card-body py-3 px-4">
                    <div class="media mb-5">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">Gavin Murray</h5>
                            <p class="font-13 text-muted">Good Looking.........</p>
                        </div>
                    </div>
                    <div class="media mb-5">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">Paul Smith</h5>
                            <p class="font-13 text-muted">Very nice ! On the other hand, we denounce with
                                righteous indignation and dislike men who are so beguiled and demoralized by
                                the </p>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">Mozelle Belt</h5>
                            <p class="font-13 text-muted">Very nice ! On the other hand, we denounce with
                                righteous indignation and dislike men who are so beguiled and demoralized by
                                the </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->

</div>
<!-- CONTAINER END -->
@endsection
