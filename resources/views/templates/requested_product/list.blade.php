@extends('layouts.master')

@section('title')
    Request List
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER Breadcrumbs-->
        <div class="page-header">
            <div>
                <h1 class="page-title">Request List</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a> </li>
                    <li class="breadcrumb-item active" aria-current="page">Request List</li>
                </ol>
            </div>
            @if (Auth::user()->hasRole('Site User'))
                <a role="button" class="btn btn-dealer" href="{{ url('/add/products') }}"> <span
                        class="fe fe-plus fs-14"></span>
                    Add Product</a>
            @endif
        </div>
        <!-- PAGE-HEADER END -->

        <!-- filters -->
        <div class="card">
            <div class="card-body px-3 py-2 pt-3">
                <div class="form-row align-items-center">
                    <div class="col-12 col-lg-6 mb-1">
                        <label for="" class="fw-bold mb-1">Search name :</label>
                        <input type="text" id="search" class="form-control" placeholder="Search ...">
                    </div>
                    {{-- <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="fw-bold mb-1">Search by status:</label>
                    <select class="form-control form-select" name="filterStatus" id="filterStatus">
                        <option value="all">Show All</option>
                        <option value="active">Parent</option>                           
                        <option value="inactive">Child</option>                           
                    </select>
                </div> --}}
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
                                <h6 class="mb-0 mt-1 text-muted">Request list</h6>
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
                                                            ID</th>
                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">
                                                            User </th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Site </th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Product</th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Quantity</th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Status</th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tBody">

                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="divLoader" class="text-center pt-5" style="height:300px;">
                                            <span>
                                                <i class="fe fe-spinner fa-spin"></i> Reqeusted products are being loading..
                                                It
                                                might take few
                                                seconds.
                                            </span>
                                        </div>
                                        <div class="row text-center" id="divNotFound" style="display:none">
                                            <h6 class="mt-lg-5" style=""><i class="bx bx-window-close"></i>
                                                {{ __('No Request Found') }} !
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
        <div class="modal fade" id="requestStatusPopup">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title fw-bold">Rquest Status</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post"id="update_request_status">

                            <div class="form-group">
                                <label class="form-label text-start fw-bold">Select status<span class="text-danger">
                                        *</span></label>
                                <select class="form-select" name="status" id="status">
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <input type="hidden" id="request_id" name="request_id">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dealer" id="btnSubmit"> <i
                                        class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                    Update</button>
                                <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom-script')
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {

            var filterLength = 1;
            var total = 0;
            var filterName = $("#search").val();
            var filterStatus = $("#filterStatus").val();
            var contentPagination = $("#content-pagination");
            var contentNotFound = $("#divNotFound");
            var contentFound = $("#divData");

            function setFilters() {
                filterName = $("#search").val()
                filterStatus = $("#filterStatus").val();
                filterLength = 10;
            }

            dataCount()

            function dataCount() {
                $("#tBody").html('');
                setFilters()
                contentPagination.twbsPagination('destroy');
                $.ajax({
                    url: '/api/product/request/count',
                    type: "get",
                    data: {
                        filterName: filterName,
                        filterLength: filterLength,
                        filterStatus: filterStatus,

                    },
                    dataType: "JSON",
                    cache: false,
                    beforeSend: function() {},
                    complete: function() {},
                    success: function(response) {
                        console.log(response);
                        if (response["status"] == "success") {
                            total = response["data"];
                            initPagination(Math.ceil(total / filterLength));
                            $("#tBody").html('');
                        } else if (response["status"] == "fail") {
                            $("#tBody").html('');
                            // toastr.error('Failed', response["msg"])
                            $("#divNotFound").css('display', 'block')
                            $("#divLoader").css('display', 'none')
                            $("#divData").css('display', 'none')
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function data(offset) {
                setFilters()
                $("#content-pagination").css('display', 'none')

                $("#tBody").html('');
                $("#divLoader").css('display', 'block')
                $("#divData").css('display', 'none')
                $("#divNotFound").css('display', 'none')
                $.ajax({
                    url: '/api/request/product/list',
                    type: "get",
                    data: {
                        filterName: filterName,
                        filterLength: filterLength,
                        filterStatus: filterStatus,
                        offset: offset,

                    },
                    dataType: "JSON",
                    cache: false,
                    beforeSend: function() {

                    },
                    complete: function() {

                    },
                    success: function(response) {
                        if (response["status"] == "fail") {
                            $("#tBody").html('');

                            $("#divLoader").css('display', 'none')
                            $("#divData").css('display', 'none')
                            $("#content-pagination").css('display', 'none')
                            $("#divNotFound").css('display', 'block')
                            // toastr.error('Failed', response["msg"])
                        } else if (response["status"] == "success") {
                            $("#divNotFound").css('display', 'none')
                            $("#divLoader").css('display', 'none')
                            $("#tBody").append(response["rows"]);
                            $("#divData").css('display', 'block');
                            $("#content-pagination").css('display', 'flex')

                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function initPagination(totalPages) {
                if (totalPages > 0) {
                    contentPagination.show();
                    contentPagination.twbsPagination({
                        totalPages: totalPages,
                        visiblePages: 4,
                        onPageClick: function(event, page) {
                            data((page === 1 ? page - 1 : ((page - 1) * filterLength)), filterLength);
                        }
                    });
                } else {
                    contentPagination.hide();
                    contentFound.hide();
                    contentNotFound.show();
                }
            }


            // $(document).on('keyup', '#search', function () {
            //     $("#tBody").html('');
            //     setFilters()
            //     dataCount()
            // });

            $(document).on('click', '#btnFilter', function(e) {
                setFilters()
                dataCount()
            })

            $(document).on('click', '#btnReset', function(e) {
                $("#search").val('')
                $("#filterSize").val('All')
                setFilters()
                dataCount()
            })

            $(document).on('click', '.btnDelete', function(e) {
                var id = $(this).attr('id')
                Swal.fire({
                        title: "Are you sure?",
                        text: "You will not be able to recover this product!",
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
                                url: '/api/request/product/delete/' + id,
                                type: "delete",
                                dataType: "JSON",
                                success: function(response) {
                                    console.log(response)
                                    if (response["status"] == "fail") {
                                        Swal.fire("Failed!", "Failed to delete site.",
                                            "error");
                                    } else if (response["status"] == "success") {
                                        Swal.fire("Deleted!", "Product has been deleted.",
                                            "success");
                                        dataCount()
                                    }
                                },
                                error: function(error) {
                                    // console.log(error);
                                },
                                async: false
                            });
                        } else {
                            Swal.close();
                        }
                    });
            });

            // edit form
            $(document).on('click', '.btnEdit', function(e) {
                var form = $(this).attr('id');
                $.ajax({
                    url: '/api/edit/form/' + id,
                    type: "GET",
                    dataType: "JSON",
                    data: {
                        form: form

                    },
                    success: function(response) {
                        // console.log(response);
                        if (response["status"] == "fail") {
                            // toastr.error('Failed', response["msg"])
                        } else if (response["status"] == "success") {
                            // toastr.success('Success', response["msg"])
                            // $("#name").val(response["data"]["name"])
                            // $("#role_id").val(response["data"]["id"])
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    },
                    async: false
                });
            });
            $("#update_request_status").on('submit', (function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/api/update/request/status',
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
                            $("#update_request_status")[0].reset();
                            $('#requestStatusPopup').modal('hide');
                            dataCount();
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });
            }));
        });

        function updateStatus(id) {
            $('#request_id').val(id);
           $('#requestStatusPopup').modal('show');
        }
    </script>
@endsection
