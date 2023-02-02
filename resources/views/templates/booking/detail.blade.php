@extends('layouts.master')

@section('title')
    Booking details
@endsection

@section('content')
    @php
        use App\Http\Controllers\BookingController;
    @endphp
    <!-- CONTAINER -->
    <div class="main-container container-fluid">


        <!-- PAGE-HEADER Breadcrumbs-->
        <div class="page-header">
            <h1 class="page-title">Booking details</h1>
            <div>
                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a> </li>
                    <li class="breadcrumb-item"><a href="{{ url('/booking/list') }}">Bookings</a> </li>
                    <li class="breadcrumb-item active" aria-current="page">Booking details</li>

                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-inline-flex justify-content-between">
                    <h3 class="card-title">Locker: #{{ ucwords($booking->locker->number) }}</h3>
                    <div>Status: <?php echo BookingController::status($booking->status); ?></div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            Booking Type: <b>{{ ucwords($booking->duration) }}</b>
                            <br>
                            Duration:
                            <br>
                            From: <badge class="badge bg-success">{{ date('m/d/Y h:i A', strtotime($booking->from)) }}
                            </badge> - Until: <badge class="badge bg-warning">
                                {{ date('m/d/Y h:i  A', strtotime($booking->to)) }}</badge>
                            <br><br>
                            <i class="fa fa-map-marker"></i> {{ $booking->site->name }}<br>
                            <br>
                            @if (strtotime($booking->to) > strtotime(date('m/d/Y H:i ')))
                                <a href="javascript:;" state="2" lockerId="{{ $booking->locker->id }}"
                                    relay="{{ $booking->locker->relay }}" class="btn btn-danger btn-lg relayState">Open
                                    Locker</a>

                                <!-- <a  href="javascript:;" state="0" lockerId="{{ $booking->locker->id }}" relay="{{ $booking->locker->relay }}" class="btn btn-secondary btn-sm relayState">Close Locker</a> -->
                            @else
                                <span class="text-danger"><i class="fe fe-clock"></i> Your booking has been expired</span>
                            @endif
                            <hr>
                            Booked By
                            <h3>{{ ucwords($booking->user->first_name) . ' ' . $booking->user->last_name }}</h3>
                            @if (isset($payment))
                                Payment Details
                                <h3>${{ $payment->amount }}</h3>
                                <a target="_blank" href="{{ $payment->receipt_url }}">View Receipt</a>
                            @endif
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
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
    <!-- CONTAINER END -->
@endsection

@section('bottom-script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
    </script>
@endsection
