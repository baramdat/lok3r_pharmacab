@extends('layouts.master')

@section('title')
Form
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">

    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <div>
            <h1 class="page-title">Forms</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Forms</li>
            </ol>
        </div>
        <a role="button" class="btn btn-dealer" href="{{ url('/form/add')}}"> <span class="fe fe-plus fs-14"></span>
            Add Form</a>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- filters -->
    <div class="card">
        <div class="card-body px-3 py-2 pt-3">
            <div class="form-row align-items-center">
                <div class="col-12 col-lg-6 mb-1">
                    <label for="" class="fw-bold mb-1">Search by form name:</label>
                    <input type="text" id="search" class="form-control" placeholder="search by name....">
                </div>
                <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="fw-bold mb-1">Search by state:</label>
                    <select class="form-control form-select" name="expiry_month" id="filterState">
                        <option value="All" selected>All</option>
                        <option value="NY">NY</option>
                        <option value="BY">BY</option>
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
                            <h6 class="mb-0 mt-1 text-muted">Forms list</h6>
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
                                                        Form name</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        State</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        Form</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        Description</th>
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
                                            <i class="fe fe-spinner fa-spin"></i> Form are being loading.. It
                                            might take few
                                            seconds.
                                        </span>
                                    </div>
                                    <div class="row text-center" id="divNotFound" style="display:none">
                                        <h6 class="mt-lg-5" style=""><i class="bx bx-window-close"></i>
                                            {{__('No Form Found')}} !
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
</div>
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
        var filterState = $("#filterState").val();

        function setFilters() {
            filterName = $("#search").val()
            filterState = $("#filterState").val();

            filterLength = 10;
        }
        formCount()

        function formCount() {
            $("#tBody").html('');

            setFilters()


            contentPagination.twbsPagination('destroy');
            $.ajax({
                url: '/api/form/count',
                type: "get",
                data: {
                    filterName: filterName,
                    filterLength: filterLength,
                    filterState: filterState,
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

        function forms(offset) {

            setFilters()
            $("#content-pagination").css('display', 'none')

            $("#tBody").html('');
            $("#divLoader").css('display', 'block')
            $("#divData").css('display', 'none')
            $("#divNotFound").css('display', 'none')
            $.ajax({
                url: '/api/forms/',
                type: "get",
                data: {
                    filterName: filterName,
                    filterLength: filterLength,
                    filterState: filterState,
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
                        forms((page === 1 ? page - 1 : ((page - 1) * filterLength)), filterLength);
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
            formCount()
        });
        $(document).on('click', '#btnFilter', function (e) {
            setFilters()
            formCount()
        })


        $(document).on('click', '#btnReset', function (e) {
            $("#search").val('')
            $("#filterState").val('All')
            setFilters()
            formCount()
        })

        $(document).on('click', '.btnDelete', function (e) {
            var id = $(this).attr('id')
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this Form!",
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
                            url: '/api/delete/form/' + id,
                            type: "delete",
                            dataType: "JSON",
                            success: function (response) {

                                if (response["status"] == "fail") {
                                    Swal.fire("Failed!", "Failed to delete Form.",
                                        "error");
                                } else if (response["status"] == "success") {
                                    Swal.fire("Deleted!", "Form has been deleted.",
                                        "success");
                                    formCount()
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

        // edit form
        $(document).on('click', '.btnEdit', function (e) {
            var form = $(this).attr('id');
            $.ajax({
                url: '/api/edit/form/' + id,
                type: "GET",
                dataType: "JSON",
                data: {
                    form: form

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
 