@extends('layouts.master')

@section('title')
Services
@endsection

@section('content')
<style>
    .detail:hover {
        cursor: pointer;
        color: blue;
    }

</style>
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <div>
            <h1 class="page-title">Service list </h1>

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">services list</li>

            </ol>
        </div>
        <a role="button" class="btn btn-dealer" href="{{url('/service/add')}}">
            <span class="fe fe-user-plus fs-14"></span> Add Service</a>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- filters -->
    <div class="row">
        <div class="card">
            <div class="card-body px-3 py-2 pt-3">
                <div class="form-row align-items-center">
                    <div class="col-12 col-lg-6 mb-1">
                        <label for="" class="fw-bold mb-1">Search by service name:</label>
                        <input type="text" id="search" class="form-control" placeholder="search by name....">
                    </div>
                    <div class="col-6 col-lg-2 mb-1">
                        <label for="" class="fw-bold mb-1">Search by status:</label>
                        <select class="form-control form-select" name="" id="filterStatus">
                            <option value="All" selected>All</option>
                            <option value="1">Active</option>
                            <option value="2">Decline</option>
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
    </div>



    <div class="row" id="divData">

    </div>



    <div id="divLoader" class="text-center pt-5" style="display:block;height:300px;">
        <span>
            <i class="bx bx-loader-circle bx-spin"></i> {{__('Service are being loading.. It might take few seconds')}}.
        </span>
    </div>
    <div class="row text-center" id="divNotFound" style="display:none">
        <h6 class="mt-lg-5" style=""><i class="bx bx-window-close"></i> {{__('No Service Found')}} !</h6>
    </div>
    <!-- pagination -->
    <div class="row mb-5">
        <div class="col-12">
            <div id="divPagination" class="">
                <ul id="content-pagination" class="pagination-sm justify-content-end" style="display:none;"></ul>
            </div>
        </div>
    </div>
</div>
<!-- CONTAINER END -->
@endsection

@section("bottom-script")
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function (e) {
        var filterLength = 1;
        var total = 0;
        var filterTitle = $("#search").val();
        var contentPagination = $("#content-pagination");
        var contentNotFound = $("#divNotFound");
        var contentFound = $("#divData");
        var filterStatus = $("#filterStatus").val();

        function setFilters() {
            filterTitle = $("#search").val() 
            filterStatus = $("#filterStatus").val()

            filterLength = 10;
        }
        serviceCount();

        function serviceCount() {
            setFilters()
            $("#divData").html(''); 
            contentPagination.twbsPagination('destroy');
            $.ajax({
                url: '/api/service/count/',
                type: "get",
                data: {
                    filterTitle: filterTitle,
                    filterLength: filterLength,
                    filterStatus: filterStatus,
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
                    } else if (response["status"] == "fail") {
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

        function services(offset, filterLength) {
            setFilters()
            $("#content-pagination").css('display', 'none')

            $("#divData").html('')
            $("#divLoader").css('display', 'block')
            $("#divData").css('display', 'none')
            $("#divNotFound").css('display', 'none')

            $.ajax({
                url: '/api/services/',
                type: "get",
                data: {
                    filterTitle: filterTitle,
                    filterLength: filterLength,
                    offset: offset,
                    filterStatus: filterStatus,
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
                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'none')
                        $("#divNotFound").css('display', 'block')
                    } else if (response["status"] == "success") {
                        $("#divNotFound").css('display', 'none')
                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'flex')
                        $("#divData").html('');
                        $("#divData").append(response["rows"])
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
                        services((page === 1 ? page - 1 : ((page - 1) * filterLength)), filterLength);
                    }
                });
            } else {
                contentPagination.hide();
                contentFound.hide();
                contentNotFound.show();
            }
        }

        $(document).on('keyup', '#search', function () {
            $("#divData").html('');
            setFilters()
            contentPagination.twbsPagination('destroy');
            serviceCount()
        });
        $(document).on('click', '#btnFilter', function (e) {
            setFilters()
            $("#divData").html('')
            contentPagination.twbsPagination('destroy');
            serviceCount()
        })


        $(document).on('click', '#btnReset', function (e) {
            $("#search").val('')
            $("#filterStatus").val('All')
            setFilters()
            $("#divData").html('')
            contentPagination.twbsPagination('destroy');
            serviceCount()
        })



        $(document).on('click', '.btnDelete', function (e) {
            var id = $(this).attr('id')
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Service!",
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
                            url: '/api/delete/service/' + id,
                            type: "delete",
                            dataType: "JSON",
                            success: function (response) {

                                if (response["status"] == "fail") {
                                    Swal.fire("Failed!", "Failed to delete Service.",
                                        "error");
                                } else if (response["status"] == "success") {
                                    Swal.fire("Deleted!", "Service has been deleted.",
                                        "success");
                                        serviceCount()
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

        // edit service
        $(document).on('click', '.btnEdit', function (e) {
            var service = $(this).attr('id');
            $.ajax({
                url: '/api/edit/service/' + id,
                type: "GET",
                dataType: "JSON",
                data: {
                    service: service

                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        // toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
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
