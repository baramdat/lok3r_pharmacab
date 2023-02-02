@extends('layouts.master')

@section('title')
Pending Transations
@endsection

@section('content')

<style>
    .detail:hover {
        cursor: pointer;
        color: blue;
    }

</style>
<style>
    #steps {
        /* width: 505px; */
        /* margin: 50px auto; */
        width: auto;
        margin: 3px 10px 3px 10px;
    }

    .step {
        width: 40px;
        height: 40px;
        background-color: white;
        display: inline-block;
        border: 4px solid;
        border-color: transparent;
        border-radius: 50%;
        color: #cdd0da;
        font-weight: 600;
        text-align: center;
        line-height: 35px;
    }

    .step:first-child {
        line-height: 40px;
    }

    .step:nth-child(n+2) {
        margin: 0 0 0 100px;
        transform: translate(0, -4px);
    }

    .step:nth-child(n+2):before {
        width: 75px;
        height: 3px;
        display: block;
        background-color: #cdd0da;
        transform: translate(-95px, 21px);
        content: '';
    }

    .step:after {
        width: 150px;
        display: block;
        transform: translate(-55px, 3px);
        color: #818698;
        content: attr(data-desc);
        font-weight: 400;
        font-size: 13px;
    }

    .step:first-child:after {
        transform: translate(-55px, -1px);
    }

    .step.active {
        border-color: #006f94;
        color: #006f94;
    }

    .step.active:before {
        background: linear-gradient(to right, #ffb5d5 0%, #dcc2f2 100%);
    }

    .step.active:after {
        color: #006f94;
        font-weight: bold;
    }

    .step.done {
        background-color: #ffb5d5;
        border-color: #ffb5d5;
        color: white;
    }

    .step.done:before {
        background-color: #ffb5d5;
    }

    .step i {
        position: relative;
        bottom: 3px;
    }

    .as-console-wrapper {
        max-height: 50px !important;
        top: auto;
        left: auto;
        right: auto;
        bottom: 0;
    }

</style>
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Pending Transations</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Pending Transations</li>

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
                    <select class="form-control form-select" name="expiry_month" id="filterType">
                        <option value="All" selected>All</option>
                        <option value="">....</option>
                    </select>
                </div>
                <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="fw-bold mb-1">Search by status:</label>
                    <select class="form-control form-select" name="expiry_month" id="filterStatus">
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
                            <h6 class="mb-0 mt-1 text-muted">All pending transaction</h6>
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
                                                        Progress</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tBody">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="divLoader" class="text-center pt-5" style="height:300px;">
                                        <span>
                                            <i class="fe fe-spinner fa-spin"></i> Pending transaction are being loading.. It
                                            might take few
                                            seconds.
                                        </span>
                                    </div>
                                    <div class="row text-center" id="divNotFound" style="display:none">
                                        <h6 class="mt-lg-5" style=""><i class="bx bx-window-close"></i>
                                            {{__('No Pending transaction Found')}} !
                                        </h6>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <div id="divPagination" class="text-center">
                                            <ul id="content-pagination" class="pagination-sm justify-content-end"
                                                style="display:none;"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>




</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function (e) {

        var filterLength = 1;
        var total = 0;
        var filterName = $("#search").val();
        var contentPagination = $("#content-pagination");
        var contentNotFound = $("#divNotFound");
        var contentFound = $("#divData");
        var filterStatus = $("#filterStatus").val();
        var filterType = $("#filterType").val();

        function setFilters() {
            filterName = $("#search").val()
            filterStatus = $("#filterStatus").val();
            filterType = $("#filterType").val();

            filterLength = 10;
        }
        pendingCount()

        function pendingCount() {
            $("#tBody").html('');

            setFilters()


            contentPagination.twbsPagination('destroy');
            $.ajax({
                url: '/api/pending/count',
                type: "get",
                data: {
                    filterName: filterName,
                    filterLength: filterLength,
                    filterStatus: filterStatus,
                    filterType: filterType,
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function () {},
                complete: function () {},
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "success") {
                        total = response["data"];
                        initPagination(Math.ceil(total / filterLength));
                        $("#tBody").html('');

                    } else if (response["status"] == "fail") {
                        $("#tBody").html('');

                        $("#divNotFound").css('display', 'block')
                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'none')
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }

        function pendings(offset) {

            setFilters()
            $("#content-pagination").css('display', 'none')

            $("#tBody").html('');
            $("#divLoader").css('display', 'block')
            $("#divData").css('display', 'none')
            $("#divNotFound").css('display', 'none')
            $.ajax({
                url: '/api/pendings/',
                type: "get",
                data: {
                    filterName: filterName,
                    filterLength: filterLength,
                    filterStatus: filterStatus,
                    filterType: filterType,
                    offset: offset
                },
                dataType: "JSON",
                cache: false,
                beforeSend: function () {

                },
                complete: function () {

                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        $("#tBody").html('');

                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'none')
                        $("#content-pagination").css('display', 'none')
                        $("#divNotFound").css('display', 'block')
                    } else if (response["status"] == "success") {
                        $("#divNotFound").css('display', 'none')
                        $("#divLoader").css('display', 'none')
                        $("#tBody").append(response["rows"]);
                        $("#divData").css('display', 'block');
                        $("#content-pagination").css('display', 'flex')

                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }

        function initPagination(totalPages) {
            if (totalPages > 0) {
                contentPagination.show();
                contentPagination.twbsPagination({
                    totalPages: totalPages,
                    visiblePages: 4,
                    onPageClick: function (event, page) {
                        pendings((page === 1 ? page - 1 : ((page - 1) * filterLength)), filterLength);
                    }
                });
            } else {
                contentPagination.hide();
                contentFound.hide();
                contentNotFound.show();
            }
        }


        $(document).on('keyup', '#search', function () {
            $("#tBody").html('');

            setFilters()
            pendingCount()
        });
        $(document).on('click', '#btnFilter', function (e) {
            setFilters()
            pendingCount()
        })


        $(document).on('click', '#btnReset', function (e) {
            $("#search").val('')
            $("#filterState").val('All')
            setFilters()
            pendingCount()
        })

        $(document).on('click', '.btnDelete', function (e) {
            var id = $(this).attr('id')
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Pending Transaction!",
                    type: "warning",
                    buttons: true,
                    confirmButtonColor: "#ff5e5e",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    dangerMode: true,
                    showCancelButton: true
                })
                .then((deleteThis) => {
                    if (deleteThis.isConfirmed) {
                        $.ajax({
                            url: '/api/delete/pending/' + id,
                            type: "delete",
                            dataType: "JSON",
                            success: function (response) {

                                if (response["status"] == "fail") {
                                    Swal.fire("Failed!", "Failed to delete Pending transaction.",
                                        "error");
                                } else if (response["status"] == "success") {
                                    Swal.fire("Deleted!", "Pending transaction has been deleted.",
                                        "success");
                                        pendingCount()
                                }
                            },
                            error: function (error) {
                                // console.log(error);
                            },
                            async: false
                        });
                    } else {
                        Swal.close();
                    }
                });
        });

        // edit pending
        $(document).on('click', '.btnEdit', function (e) {
            var pending = $(this).attr('id');
            $.ajax({
                url: '/api/edit/transaction/' + id,
                type: "GET",
                dataType: "JSON",
                data: {
                    pending: pending

                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        // toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        // toastr.success('Success', response["msg"])
                        // $("#name").val(response["data"]["name"])
                        // $("#role_id").val(response["data"]["id"])
                    }
                },
                error: function (error) {
                    // console.log(error);
                },
                async: false
            });
        });


    });

</script>
@endsection
