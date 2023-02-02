@extends('layouts.master')

@section('title')
Book locker
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Book locker</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/locker/list')}}">Bookings</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Book locker</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Book locker</h3>
            </div>
            <div class="card-body">
                <div id="divSize" class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <?php
                            $sizesArr = App\Models\LockerSize::all();                            
                            ?>
                            <label class="form-label mb-0">Size: <span class="text-danger">*</span></label>
                            <select class="form-select" name="size_id" id="size_id" required>
                                <option value="">choose size</option>
                                @foreach ($sizesArr as $size)
                                    <option value="{{$size->id}}">{{$size->size}}</option>
                                @endforeach                                
                            </select>
                        </div>

                        <div id="divAvailable" style="display:none" class="form-group col-lg-12 col-sm-12">
                            <i class="fe fe-check-circle text-success"></i>
                            <span><b id="lockersAvailable">0</b> locker(s) are available</span>
                        </div>

                        <div id="divNotAvailable" style="display:none" class="form-group col-lg-12 col-sm-12">
                            <i class="fe fe-clock text-warning"></i>
                            <span>All <b id="lockerSize">S</b> size lockers are occupied. Please check for other sizes</span>
                        </div>
                    </div>
                    
                    <div class="col-lg-2"></div>

                </div>
                <div id="divDuration" class="row" style="display:none">
                    <div class="col-lg-2"></div>
                    <div class="form-group col-lg-8">
                        <label class="form-label mb-0">Duration: <span class="text-danger">*</span></label>
                        <select class="form-select" name="duration" id="duration" required>
                            <option value="">choose duration</option>
                            <option value="hourly">Hour</option>
                            <option value="daily">Daily</option>                              
                            <option value="monthly">Monthly</option>
                        </select>
                        <span class="pt-1" id="paymentLoader" style="display:none"><i class="fa fa-spin fa-spinner text-info"></i> Payment form is being loading</span>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div id="divForm" class="row" style="display:none">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8 pl-0">

                        <form class="row" method="post" id="payment-form" style="display:block">
                            @csrf  
                            <input type="hidden" name="locker_size_id" id="locker_size_id" value="">
                            <input type="hidden" name="duration" id="booking_duration" value="">

                            <div class="form-group col-lg-12 col-sm-12 text-center">
                                Amount to pay <br>
                                <h1 id="htmlAmount">$0</h1>
                            </div>
                            
                            <div class="form-group">
                                <div class="card-header">
                                    <label for="payment-element">
                                        <small>Enter your credit card information to pay</small>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <div id="payment-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
                                    <input type="hidden" name="token" value="" />
                                </div>
                                <input type="hidden" name="total_amount" id="totalAmount" value="20">
                            </div>
                            <div class="card-footer">
                                <button
                                id="card-button"
                                class="btn btn-primary"
                                type="submit"> <i class="fa fa-spin fa-spinner fa-book-now" style="display: none"></i> Book Now </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div id="divSuccess" class="row" style="display:none">
                    <div class="col-lg-12 text-center">
                        <i class="fe fe-check-circle text-success" style="font-size:4rem"></i>
                        <br>
                        Your locker has been booked successfully!
                        <br>
                        <small>Please not down your locker number</small>
                        <br>
                        <h6 id="lockerNumber">LS-001</h6>
                        <a id="bookingDetails" href="{{url('/booking/details')}}">View Booking Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    

</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://js.stripe.com/v3/"></script>
<script>

$(document).ready(function (e) {
        var sizeArr = []
        $('#size_id').on('change',function(e){
            $("#locker_size_id").val('')
            $("#divAvailable").hide()
            $("#divNotAvailable").hide()
            $("#divDuration").hide()
            $("#payment-form").hide();
            $("#totalAmount").val(0)
            $("#htmlAmount").html('$0')
            var size_id = $(this).val();
            var size = $("#size_id option:selected" ).text();
            if(size_id == ''){
                toastr.info('Size', 'Please select size to continue')
            }else{
                $.ajax({
                    url: '/api/locker/available',
                    type: "POST",
                    data: {size_id:size_id},
                    dataType: "JSON",
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (response) {
                        if (response["status"] == "fail") {
                            toastr.error('Failed', response["msg"])
                            $("#lockerSize").html(size)
                            $("#divNotAvailable").show()
                            $('#duration').val('')
                            $("#divForm").hide()
                        } else if (response["status"] == "success") {
                            toastr.success('Success', response["msg"])
                            $("#lockersAvailable").html(response["data"])
                            $("#divAvailable").show()
                            $("#payment-form").show();
                            $("#divDuration").show()
                            $("#locker_size_id").val(size_id)
                        }
                    },
                    error: function (error) {
                        // console.log(error);
                    }
                });
            }            
        })

        $('#duration').on('change',function(e){
            $("#card-button").attr('disabled',true)
            var duration = $(this).val();
            var size_id = $('#size_id').val();
            $("#totalAmount").val(0)
            $("#htmlAmount").html('$0')
            $("#divForm").hide()
            $("#paymentLoader").hide()
            if(duration == ''){
                toastr.info('Size', 'Please select duration to continue')
            }else{
                $("#booking_duration").val(duration)
                $.ajax({
                    url: '/api/locker/pricing',
                    type: "POST",
                    data: {size_id:size_id,duration:duration},
                    dataType: "JSON",
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (response) {
                        if (response["status"] == "fail") {
                            toastr.error('Failed', response["msg"])
                        } else if (response["status"] == "success") {
                            toastr.success('Success', response["msg"])
                            $("#totalAmount").val(response["data"])
                            $("#htmlAmount").html('$'+response["data"])
                            $("#card-button").attr('disabled',false)
                            $("#divForm").show()
                            setupStripe(response["data"])
                            $("#paymentLoader").hide()
                        }
                    },
                    error: function (error) {
                        // console.log(error);
                    }
                });
            }            
        })
    });

    function setupStripe(amount){
        // Create a Stripe client.   

        var stripe = Stripe('{{env("STRIPE_KEY")}}');
                
        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const clientSecret = paymentIntent(amount)
        function paymentIntent(amount){
            var data = ''
            $.ajax({
                url: '/api/payment/intent',
                type: "POST",
                data: {amount: amount},
                dataType: "JSON",
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (response) {
                    data = response.data
                },
                error: function (error) {
                    console.log(error);
                },
                async: false
            });
            return data;
        }
        
        const options = {
            clientSecret: clientSecret,
        };
        // Create an instance of Elements.
        var elements = stripe.elements(options);

        // Create an instance of the card Element.
        var card = elements.create('payment', {style: style});
            
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#payment-element');
            
        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
    }
    
    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                console.log(result)
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });
    
    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        
        // Submit the form
        // form.submit();

        $.ajax({
            url: '/api/payment/create',
            type: "POST",
            data: new FormData(form),
            dataType: "JSON",
            processData: false,
            contentType: false, 
            cache: false,
            beforeSend: function () {
                $("#card-button").attr('disabled', true);
                $(".fa-book-now").css('display', 'inline-block');
            },
            complete: function () {
                $("#card-button").attr('disabled', true);
                $(".fa-book-now").css('display', 'none');
            },
            success: function (response) {
                if (response["status"] == "fail") {
                    toastr.error('Failed', response["msg"])
                } else if (response["status"] == "success") {
                    toastr.success('Success', response["msg"])
                    $("#divSize").css('display','none')
                    $("#divForm").css('display','none')
                    $("#divSuccess").css('display','block')
                    $("#lockerNumber").html(response.data.lockerNumber)
                    $("#bookingDetails").attr('href',"/booking/details/"+response.data.bookingId)
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

</script>
@endsection
