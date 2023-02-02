@extends('layouts.master')

@section('title')
Completed Transations
@endsection

@section('content')
<style>
    .detail:hover{
        cursor: pointer;
        color:blue;
    }
</style>
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Completed Transations</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Completed Transations</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- filters -->
    <div class="card">
        <div class="card-body px-3 py-2 pt-3">
            <div class="form-row align-items-center">
                <div class="col-12 col-lg-4 mb-1">
                    <label for="" class="fw-bold mb-1">Search by registrant:</label>
                    <input type="text" id="search" class="form-control" placeholder="search by name....">
                </div>
                <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="fw-bold mb-1">Search by transaction type:</label>
                    <select class="form-control form-select" name="expiry_month" id="filterMonth">
                        <option value="All" selected>All</option>
                        <option value="">....</option>
                    </select>
                </div>
                <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="fw-bold mb-1">Search by status:</label>
                    <select class="form-control form-select" name="expiry_month" id="filterMonth">
                        <option value="All" selected>All</option>
                        <option value="">....</option>
                    </select>
                </div>
                <!-- <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="fw-bold mb-1">Search by year:</label>
                    <select class="form-control form-select" name="expiry_year" id="filterYear">
                        <option value="All" selected>All</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div> -->
                <div class="col-12 col-lg-2 mb-1 ">
                    <label for="" class="mb-1"></label>

                    <button id="btnFilter" type="button" class="btn btn-dealer btn-block">Filter</button>
                </div>
                <div class="col-12 col-lg-2 mb-1 ">
                    <label for="" class="mb-1"></label>

                    <button id="btnReset" type="button" class="btn btn-outline-info btn-block">Reset</button>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
            <div class="card-header  mx-1">
                <div class="media">
                        <div class="media-body">
                            <h6 class="mb-0 mt-1 text-muted">All Completed transaction</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="grid-margin">
                        <div class="">
                            <div class="panel panel-primary">
                                
                                <div class="panel-body tabs-menu-body border-0 pt-0">
                                    <div class="table-responsive">
                                        <table id="data-table" class="table table-bordered text-nowrap mb-0">
                                            <thead class="border-top">
                                                <tr>
                                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">
                                                        Reference no</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        Registrant</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        State</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        Transaction type</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td class="text-center">
                                                        <div class="mt-0 mt-sm-2 d-block">
                                                            <h6 class="mb-0 fs-14 ">
                                                                DRL-1234</h6>
                                                        </div>
                                                    </td>
                                                    <td class="detail" onclick="window.location='{{ url('transaction/detail') }}'">
                                                    <div class="ms-3 mt-0 mt-sm-2 d-block">
                                                                <h6 class="mb-0 fs-14 ">
                                                                    Jhon Doe</h6>
                                                            </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="mt-0 mt-sm-3 d-block">
                                                                <h6 class="mb-0 fs-14 ">
                                                                    NY</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="mt-sm-2 d-block">Lien Correction</span></td>
                                                    
                                                    <td>
                                                        <div class="mt-sm-1 d-block">
                                                            <span
                                                                class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom ">
                                                    <td class="text-center">
                                                        <div class="mt-0 mt-sm-2 d-block">
                                                            <h6 class="mb-0 fs-14 ">
                                                                DRL-1235</h6>
                                                        </div>
                                                    </td>
                                                    <td class="detail" onclick="window.location='{{ url('transaction/detail') }}'">
                                                    <div class="ms-3 mt-0 mt-sm-2 d-block">
                                                                <h6 class="mb-0 fs-14 ">
                                                                    Steve smith</h6>
                                                            </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="mt-0 mt-sm-3 d-block">
                                                                <h6 class="mb-0 fs-14 ">
                                                                    FC</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="mt-sm-2 d-block">Duplicate title</span></td>
                                                    
                                                    <td>
                                                        <div class="mt-sm-1 d-block">
                                                            <span
                                                                class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom ">
                                                    <td class="text-center">
                                                        <div class="mt-0 mt-sm-2 d-block">
                                                            <h6 class="mb-0 fs-14 ">
                                                                DRL-1236</h6>
                                                        </div>
                                                    </td>
                                                    <td class="detail" onclick="window.location='{{ url('transaction/detail') }}'">
                                                    <div class="ms-3 mt-0 mt-sm-2 d-block">
                                                                <h6 class="mb-0 fs-14 ">
                                                                    David warner</h6>
                                                            </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="mt-0 mt-sm-3 d-block">
                                                                <h6 class="mb-0 fs-14 ">
                                                                    CT</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="mt-sm-2 d-block">Registration</span></td>
                                                    
                                                    <td>
                                                        <div class="mt-sm-1 d-block">
                                                            <span
                                                                class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed</span>
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
        </div>
    </div>

    <!-- pagination -->
    <div class="row" style="float:right !important;">
        <div class="col-md-12 col-xl-6 ">
            <ul class="pagination">
                <li class="page-item page-prev">
                    <a class="page-link" href="javascript:void(0)" tabindex="-1">Prev</a>
                </li>
                <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0)">4</a></li>
                <li class="page-item page-next">
                    <a class="page-link" href="javascript:void(0)">Next</a>
                </li>
            </ul>
        </div>
    </div>

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {

    })

</script>

@endsection
