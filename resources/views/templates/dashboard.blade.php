@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <style>
        .card {
            margin-bottom: 0.5rem;
        }

        button {
            border-style: none;
        }

        .card-body {
            height: 450px;
        }

        .counter-show {
            background-color: rgb(145, 188, 224);
            border-color: rgb(145, 188, 224);
            color: white;
            text-align: center;
            border-style: none;
        }

        .total-count {
            background-color: rgb(145, 188, 224);
            border-color: rgb(145, 188, 224);
            margin-right: 33px;
            color: white;
            text-align: center;
            margin-top: 7px;
            border-style: none;
        }

        .top-button {
            margin-left: 250px;
        }

        @media only screen and (max-width: 992px) {


            td#increment-sign {
                width: 70px;
            }

            .counter-show {
                width: 70px;
            }
        }

        @media only screen and (max-width: 600px) {
            .counter-show {
                width: 70px;
            }

            .total-count {
                width: 70px;
                margin-right: 3px;
            }

            .top-button {
                margin-left: 100px;
            }

            td#increment-sign {
                width: 70px;
            }

            .card-body {
                height: 100%;
            }
        }
    </style>
    @php
        use App\Http\Controllers\BookingController;
    @endphp
    <!-- CONTAINER -->
    <div class="main-container container-fluid">


        <!-- PAGE-HEADER Breadcrumbs-->
        <div class="page-header">
            <h1 class="page-title">Dashboard </h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 -->

        <div class="row">
            <div class="col-12 mb-3">
                Hello {{ Auth::user()->first_name }} | <small
                    class="badge bg-success">{{ ucwords(Auth::user()->roles->pluck('name')[0]) }}</small>
                <?php
                if (Auth::user()->site_id != '') {
                    echo '| <i class="fa fa-map-marker"></i> ' . Auth::user()->site->name;
                }
                ?>
            </div>
            @if (!Auth::user()->hasRole('User'))
                <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                    <div class="card border p-0 overflow-hidden shadow-none">
                        <form id="available_product">
                            @csrf
                            <div class="card-header">
                                <div class="media mt-0">
                                    <div class="media-body">
                                        <h4 class="mb-0 mt-1">Available Product</h4>

                                    </div>

                                </div>
                                <button type="submit" class="badge bg-success p-2 top-button">Open Locker</button>
                            </div>

                            <div class="card-body py-3 px-4" style="overflow-y: scroll;   scrollbar-width: none;">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-hover mb-0">

                                                <tbody>
                                                    @foreach ($products as $key => $product)
                                                        <tr>
                                                            <td><b>{{ ucwords($product->inventory_item->name) }}</b></td>
                                                            <td>
                                                                <badge class="badge bg-success p-2" style="">
                                                                    {{ $product->quantity }}
                                                                </badge>
                                                            </td>

                                                            {{-- @if (!Auth::user()->hasRole('Site User')) --}}
                                                            <td id="increment-sign">
                                                                <badge class="badge bg-danger p-2"
                                                                    style="border-radius:50%;"
                                                                    onclick="subtract('{{ $product->inventory_item->id }}')">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </badge>
                                                                <badge class="badge bg-success p-2"
                                                                    onclick="add('{{ $product->inventory_item->id }}')"
                                                                    style="border-radius:50%;">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </badge>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="counter-show"
                                                                    id="product_{{ $product->inventory_item->id }}"
                                                                    name="product[{{ $product->inventory_item->id }}]"
                                                                    value="0"style="" readonly>
                                                            </td>
                                                            {{-- @endif --}}

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- @if (!Auth::user()->hasRole('Site User')) --}}
                                            <input type="hidden" id="total_product" name="total_product" value="0">
                                            <input type="text" id="total_product_count"
                                                class="total-count pull-right mt-1" value="" placeholder="Total:   0"
                                                readonly>
                                            {{-- @endif --}}
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
                    <div class="card border p-0 overflow-hidden shadow-none">
                        <form id="requested_product_form">
                            @csrf
                            <div class="card-header">
                                <div class="media mt-0">
                                    <div class="media-body">
                                        <h4 class="mb-0 mt-1">Requested Product</h4>
                                    </div>
                                </div>
                                <button type="submit" class="badge bg-success p-2 top-button">Requested Product</button>
                            </div>
                            <div class="card-body py-3 px-4" style=" overflow-y: scroll;   scrollbar-width: none;">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-hover mb-0">

                                                <tbody>
                                                    @foreach ($product_request as $product)
                                                        <tr>
                                                            <td><b>{{ ucwords($product->inventory_item->name) }}</b></td>
                                                            <td>
                                                                <badge class="badge bg-warning p-2">
                                                                    {{ $product->quantity }}
                                                                </badge>
                                                            </td>
                                                            {{-- @if (!Auth::user()->hasRole('Site User')) --}}
                                                            <td id="increment-sign">
                                                                <badge class="badge bg-danger p-2"
                                                                    onclick="subtractRequest('{{ $product->id }}')"
                                                                    style="border-radius:50%;">
                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                </badge>
                                                                <badge class="badge bg-success p-2"
                                                                    onclick="addRequest('{{ $product->id }}')"
                                                                    style="border-radius:50%;">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                                </badge>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="counter-show"
                                                                    id="requestedproduct-{{ $product->id }}"
                                                                    name="requestedproduct[{{ $product->inventory_item->id }}]"
                                                                    value="0"style="" readonly>
                                                            </td>
                                                            {{-- @endif --}}


                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                             @if ($product_request->count()>0) 
                                            <input type="hidden" id="total-requested-product"
                                                name="total-requested-product" value="0">
                                            <input type="text" id="total_requested_product_count"
                                                class="total-count pull-right" value="" placeholder="Total:   0"
                                                readonly>
                                         @endif 
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    {{-- <div class="pull-right" style="margin-right:300px;"> --}}
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <a href="{{ url('products/list') }}" class="badge bg-info p-2 m-3 ">View All Products</a>
                            @if (!Auth::user()->hasRole('Site User'))
                                <a href="{{ url('add/products') }}" class="badge bg-warning p-2 m-3">Add Product</a>
                                <a href="{{ url('add/categories') }}" class="badge bg-info p-2 m-3 ">Add Category</a>
                            @endif

                        </div>
                        <div class="col-lg-4"></div>
                    </div>

                    {{-- </div> --}}
                </div>
                {{-- <div class="col-lg-12 mt-2">
                    @if (Auth::user()->hasRole('Site User'))
                        <a href="javascript:void(0)" class="badge bg-success p-2 m-4 " id="take_product">Take Product</a>
                    @endif
                    <div class="card border p-0 overflow-hidden shadow-none">
                        <div class="card-header">
                            <div class="media mt-0">
                                <div class="media-body">
                                    <h4 class="mb-0 mt-1">Requested Product</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-3 px-4"
                            style="max-height: 295px; overflow-y: scroll;   scrollbar-width: none;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="requested_product_form">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-hover mb-0">

                                                <tbody>
                                                    @foreach ($product_request as $product)
                                                        <tr>
                                                            <td>
                                                                <p class="p-2"> Products requested from
                                                                    <b>{{ ucwords($product->site->name) }}</b> by
                                                                    <b>{{ ucwords($product->user->first_name) }}
                                                                        {{ $product->user->last_name }}</b> Requested
                                                                    <b>{{ $product->quantity }}</b> boxes of <b><a
                                                                            href="{{ url('products/list') }}?id={{ $product->product_id }}">{{ ucwords($product->inventory_item->name) }}</a></b>
                                                                </p>
                                                            </td>
                                                            @if (!Auth::user()->hasRole('Site User'))
                                                                <td>
                                                                    <badge class="badge bg-danger p-2"
                                                                        onclick="subtractRequest('{{ $product->id }}')"
                                                                        style="border-radius:50%;">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </badge>
                                                                    <badge class="badge bg-success p-2"
                                                                        onclick="addRequest('{{ $product->id }}')"
                                                                        style="border-radius:50%;">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                                    </badge>
                                                                    <input type="text"
                                                                        id="requestedproduct-{{ $product->id }}"
                                                                        name="requestedproduct[{{ $product->inventory_item->id }}]"
                                                                        value="0"style="background-color: rgb(145, 188, 224); border-color:rgb(145, 188, 224); width:100px; color: white; text-align: center; border-style: none;"
                                                                        readonly>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if (!Auth::user()->hasRole('Site User'))
                                                <input type="hidden" id="total-requested-product"
                                                    name="total-requested-product" value="0">
                                                <input type="text" id="total_requested_product_count"
                                                    class="pull-right" value="Total:         0"
                                                    style="background-color: rgb(145, 188, 224); border-color:rgb(145, 188, 224); width:200px; color: white; text-align: center; margin-top:7px; border-style: none;"
                                                    readonly>
                                            @endif
                                        </div>


                                        @if ($product_request->count() > 5)
                                            <a href="{{ route('request.list') }}"
                                                class="btn btn-info btn-sm pull-right mt-3">View
                                                All Requests</a>
                                        @endif
                                </div>

                            </div>

                        </div>
                    </div>
                    @if (!Auth::user()->hasRole('Site User'))
                        <button type="submit" class="badge bg-success p-2 pull-right"
                            style=" border-style: none; margin-right:100px ;">Reuested Products</button>
                    @endif
                    </form>
                </div> --}}
                <div class="col-lg-12 mt-3">
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
                                                        <td>{{ ucwords($locker->user->first_name) }}
                                                            {{ $locker->user->last_name }}</td>
                                                        <td><a
                                                                href="{{ url('products/list') }}?id={{ $locker->item_id }}">{{ ucwords($locker->inventory_item->name) }}</a>
                                                        </td>
                                                        <td>{{ ucwords($locker->site->name) }}</td>
                                                        <td>{{ $locker->locker->number }}</td>
                                                        <td>{{ $locker->quantity }}</td>
                                                        <td>{{ $locker->notes }}</td>
                                                        <td>{{ date_format($locker->created_at, 'M d ,Y  H:i A') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route('locker.opening.history') }}"
                                        class="btn btn-info btn-sm pull-right mt-3">View
                                        All</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- ROW-1 END -->
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
                                        <option value="{{ $item->item_id }}">{{ ucwords($item->inventory_item->name) }}
                                        </option>
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
                                <input type="hidden" id="locker_id_history" name="locker_id_history" value="3">
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
    <!-- CONTAINER END -->
    <script></script>
@endsection
@section('bottom-script')
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("#requested_product_form").on('submit', (function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ url('/api/product/request/add') }}",
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
                            $("#requested_product_form")[0].reset();
                            setTimeout(() => {
                                location.reload();
                            }, 5000);
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });

            }));

            $('#available_product').on('submit', function(e) {
                e.preventDefault();
                if ($('#total_product').val() > 0) {
                    $.ajax({
                        url: "{{ url('/api/update/product/quantity') }}",
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
                                $("#requested_product_form")[0].reset();
                                setTimeout(() => {
                                    location.reload();
                                }, 5000);
                            }
                        },
                        error: function(error) {
                            // console.log(error);
                        }
                    });
                } else {
                    toastr.error('Failed', 'Please add product quantity')
                }
            });
            $('#take_product').on('click', function(e) {
                $('#lockerHistoryModel').modal('show');

            });
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
                            // locker_histoy(lockerId, relay, state);
                            toastr.success('Success', response["msg"])
                            $("#add_locker_history")[0].reset();
                            $('#lockerHistoryModel').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 5000);
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });
            }));
        });

        function add(id) {
            const val = $('#product_' + id).val();
            var value = parseInt(val) + 1;
            $('#product_' + id).val(value);
            const total = $('#total_product').val();
            var total_new = parseInt(total) + 1;
            $('#total_product').val(total_new);
            $('#total_product_count').val('Total:      ' + total_new);
            // alert(vall);
        }

        function subtract(id) {
            const val = $('#product_' + id).val();
            if (val >= 1) {
                var value = parseInt(val) - 1;
                $('#product_' + id).val(value);
                const total = $('#total_product').val();
                var total_new = parseInt(total) - 1;
                $('#total_product').val(total_new);
                $('#total_product_count').val('Total:     ' + total_new);
            }
        }

        function addRequest(id) {
            const val = $('#requestedproduct-' + id).val();
            var value = parseInt(val) + 1;
            $('#requestedproduct-' + id).val(value);
            const total = $('#total-requested-product').val();
            var total_new = parseInt(total) + 1;
            $('#total-requested-product').val(total_new);
            $('#total_requested_product_count').val('Total:    ' + total_new);
            // alert(vall);
        }

        function subtractRequest(id) {
            const val = $('#requestedproduct-' + id).val();
            if (val >= 1) {
                var value = parseInt(val) - 1;
                $('#requestedproduct-' + id).val(value);
                const total = $('#total-requested-product').val();
                var total_new = parseInt(total) - 1;
                $('#total-requested-product').val(total_new);
                $('#total_requested_product_count').val('Total:     ' + total_new);
            }
        }
    </script>
@endsection
