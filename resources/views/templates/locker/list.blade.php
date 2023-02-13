@extends('layouts.master')

@section('title')
    Lockers List
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER Breadcrumbs-->
        <div class="page-header">
            <div>
                <h1 class="page-title">Lockers List</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a> </li>
                    <li class="breadcrumb-item active" aria-current="page">Lockers List</li>
                </ol>
            </div>
            @if (!Auth::user()->hasRole('Site User'))
                <a role="button" class="btn btn-dealer" href="{{ url('/locker/add') }}"> <span
                        class="fe fe-plus fs-14"></span>
                    Add Locker</a>
            @endif
        </div>
        <!-- PAGE-HEADER END -->

        <!-- filters -->
        <div class="card">
            <div class="card-body px-3 py-2 pt-3">
                <div class="form-row align-items-center">
                    <div class="col-12 col-lg-6 mb-1">
                        <label for="" class="fw-bold mb-1">Search by locker no. :</label>
                        <input type="text" id="search" class="form-control" placeholder="LS-001">
                    </div>
                    <div class="col-12 col-lg-6 mb-1">
                        <label for="" class="fw-bold mb-1">Row:</label>
                        <input type="number" id="filterRow" name="filterRow" class="form-control" placeholder="">
                    </div>
                    <div class="col-12 col-lg-6 mb-1">
                        <label for="" class="fw-bold mb-1">Column:</label>
                        <input type="number" id="filterColumn" name="filterColumn" class="form-control" placeholder="">
                    </div>
                    <div class="col-6 col-lg-2 mb-1">
                        <?php
                        $sizesArr = App\Models\LockerSize::all();
                        ?>
                        <label for="" class="fw-bold mb-1">Search by size:</label>
                        <select class="form-control form-select" name="filterSize" id="filterSize">
                            <option value="all">Show All</option>
                            @foreach ($sizesArr as $size)
                                <option value="{{ $size->id }}">{{ $size->size }}</option>
                            @endforeach
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
                                <h6 class="mb-0 mt-1 text-muted">Lockers list</h6>
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
                                                            Locker No</th>
                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">
                                                            Site Name</th>
                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">
                                                            Relay #</th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Size</th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Row</th>
                                                        <th class="bg-transparent border-bottom-0">
                                                            Column</th>
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
                                                <i class="fe fe-spinner fa-spin"></i> Lockers are being loading.. It
                                                might take few
                                                seconds.
                                            </span>
                                        </div>
                                        <div class="row text-center" id="divNotFound" style="display:none">
                                            <h6 class="mt-lg-5" style=""><i class="bx bx-window-close"></i>
                                                {{ __('No Locker Found') }} !
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
        <div class="modal fade" id="lockerHistoryModel">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title fw-bold">Locker history</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post"id="add_locker_history">

                            <div class="form-group">
                                <label class="form-label text-start fw-bold">Select Product<span class="text-danger">
                                        *</span></label>
                                <select class="form-select" name="product" id="product">
                                    @foreach ($inventory_item as $item)
                                        <option value="{{ $item->item_id }}">{{ ucwords($item->inventory_item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label text-start fw-bold">Quantity<span class="text-danger">
                                        *</span></label>
                                <input type="number" class="form-control" name="quantity" id="quantity" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label text-start fw-bold">Action <span class="text-danger">
                                        *</span></label>
                                <label class="radio-inline pull-left" style="padding-right: 20px;padding-left: 10px;">
                                    <input type="radio" name="product_action" checked value="add">Add
                                </label>
                                <label class="radio-inline pull-left pe-1">
                                    <input type="radio" id="subtract" name="product_action" value="sub">Subtract
                                </label>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="form-label text-start fw-bold">Enter reason why your opening locker? <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="locker_opening_reason" name="locker_opening_reason" rows="3" required></textarea>
                                <input type="hidden" id="locker_id_history" name="locker_id_history">
                                <input type="hidden" id="locker_id_state" name="locker_id_state">
                                <input type="hidden" id="locker_id_relay" name="locker_id_relay">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dealer" id="btnSubmit"> <i
                                        class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                    Save</button>
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
            var filterLockerNo = $("#search").val();
            var contentPagination = $("#content-pagination");
            var contentNotFound = $("#divNotFound");
            var contentFound = $("#divData");
            var filterSize = $("#filterSize").val();
            var filterRow = $("#filterRow").val();
            var filterColumn = $("#filterColumn").val();

            function setFilters() {
                filterLockerNo = $("#search").val()
                filterSize = $("#filterSize").val();
                filterRow = $("#filterRow").val();
                filterColumn = $("#filterColumn").val();

                filterLength = 3;
            }
            lockerCount()

            function lockerCount() {
                $("#tBody").html('');
                setFilters()
                contentPagination.twbsPagination('destroy');

                $.ajax({
                    url: '/api/locker/count',
                    type: "get",
                    data: {
                        filterLockerNo: filterLockerNo,
                        filterLength: filterLength,
                        filterSize: filterSize,
                        filterRow: filterRow,
                        filterColumn: filterColumn,
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
                            toastr.error('Failed', response["msg"])
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

            function lockers(offset) {
                setFilters()
                $("#content-pagination").css('display', 'none')

                $("#tBody").html('');
                $("#divLoader").css('display', 'block')
                $("#divData").css('display', 'none')
                $("#divNotFound").css('display', 'none')
                $.ajax({
                    url: '/api/locker/list',
                    type: "get",
                    data: {
                        filterLockerNo: filterLockerNo,
                        filterLength: filterLength,
                        filterSize: filterSize,
                        filterRow: filterRow,
                        filterColumn: filterColumn,
                        offset: offset
                    },
                    dataType: "JSON",
                    cache: false,
                    beforeSend: function() {

                    },
                    complete: function() {

                    },
                    success: function(response) {
                        console.log(response);
                        if (response["status"] == "fail") {
                            $("#tBody").html('');

                            $("#divLoader").css('display', 'none')
                            $("#divData").css('display', 'none')
                            $("#content-pagination").css('display', 'none')
                            $("#divNotFound").css('display', 'block')
                            toastr.error('Failed', response["msg"])
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
                            lockers((page === 1 ? page - 1 : ((page - 1) * filterLength)),
                                filterLength);
                        }
                    });
                } else {
                    contentPagination.hide();
                    contentFound.hide();
                    contentNotFound.show();
                }
            }

            $(document).on('keyup', '#search', function() {
                $("#tBody").html('');
                setFilters()
                lockerCount()
            });

            $(document).on('click', '#btnFilter', function(e) {
                setFilters()
                lockerCount()
            })

            $(document).on('click', '#btnReset', function(e) {
                $("#search").val('')
                $("#filterSize").val('All')
                setFilters()
                lockerCount()
            })

            $(document).on('click', '.btnDelete', function(e) {
                var id = $(this).attr('id')
                Swal.fire({
                        title: "Are you sure?",
                        text: "You will not be able to recover this locker!",
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
                                url: '/api/locker/delete/' + id,
                                type: "delete",
                                dataType: "JSON",
                                success: function(response) {
                                    console.log(response)
                                    if (response["status"] == "fail") {
                                        Swal.fire("Failed!", "Failed to delete locker.",
                                            "error");
                                    } else if (response["status"] == "success") {
                                        Swal.fire("Deleted!", "Locker has been deleted.",
                                            "success");
                                        lockerCount()
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


            // open close relay
            $(document).on('click', '.relayState', function(e) {

                $('#locker_id_history').val($(this).attr('lockerId'));
                $('#locker_id_state').val($(this).attr('state'));
                $('#locker_id_relay').val($(this).attr('relay'));
                //  var lockerId = $(this).attr('lockerId');
                //  var relay = $(this).attr('relay');
                //  var state = $(this).attr('state');
                //  console.log('locker'+lockerId+'state'+state+'relay'+state);
                $('#lockerHistoryModel').modal('show');

            });

            function locker_histoy(lockerId, relay, state) {
                $.ajax({
                    url: '/api/relay/state/update',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        lockerId: lockerId,
                        relay: relay,
                        state: state
                    },
                    success: function(response) {
                        if (response["status"] == "fail") {
                            toastr.error('Failed', response["msg"])
                        } else if (response["status"] == "success") {
                            toastr.success('Success', response["msg"])
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    },
                    async: false
                });
            }
            $("#add_locker_history").on('submit', (function(e) {
                var lockerId = $('#locker_id_history').val();
                var relay = $('#locker_id_relay').val();
                var state = $('#locker_id_state').val();
                e.preventDefault();
                $.ajax({
                    url: '/api/locker_histor/add',
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
                            locker_histoy(lockerId, relay, state);
                            //toastr.success('Success', response["msg"])
                            $("#add_locker_history")[0].reset();
                            $('#lockerHistoryModel').modal('hide');
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });
            }));
        });
    </script>
@endsection
