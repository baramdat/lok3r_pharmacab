@extends('layouts.master')

@section('title')
New Transation
@endsection

@section('content')

<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">New Transation</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">New Transation</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- Row -->
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="card-title">
                        Add new transaction
                    </div>
                </div>
                <div class="card-body">
                    <form action="" id="add_transaction">
                        <div id="wizard2">
                            @csrf
                            <h3>Transaction detail</h3>
                            <section>
                                <div class="control-group form-group">
                                    <label class="form-label mb-0">What state is this transaction for ?</label>
                                    <select name="trans_state" class="form-control form-select" id="trans_state"
                                        required data-bs-placeholder="">
                                        <option selected disabled>chosse state</option>
                                        <option value="abc_state">ABC state </option>
                                    </select>
                                </div>
                                <div class="control-group form-group">
                                    <label class="form-label mb-0">What type of transaction is this for ?</label>
                                    <select name="trans_type" class="form-control form-select" id="trans_type" required
                                        data-bs-placeholder="">
                                        <option selected disabled>chosse transaction type</option>
                                        <option value="trans_type ">ABC transaction type</option>
                                    </select>
                                </div>
                                <div class="control-group form-group">
                                    <label class="form-label mb-0">What type of registration is this for ?</label>
                                    <select name="reg_type" class="form-control form-select" id="reg_type" required
                                        data-bs-placeholder="">
                                        <option selected disabled>chosse transaction type</option>
                                        <option value="reg_type">Registration type</option>
                                    </select>
                                </div>
                                <div class="control-group form-group">
                                    <label class="form-label mb-0">Is this vehicle being financed ?</label>
                                    <div class="form-group d-flex">
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control px-0 text-muted mb-0 tx-13">
                                                <label class="rdiobox p-0">
                                                    <input type="hidden" name="" class="is_finance" id="is_finance_yes">
                                                    <input name="is_finance" type="radio"
                                                        id="finance-yes" value="yes">
                                                    <span class="text-muted">Yes</span></label>

                                            </div>

                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control text-muted mb-0 tx-13">
                                                <label class="rdiobox p-0">
                                                    <input type="hidden" name="" class="is_finance" id="is_finance_no">
                                                    <input name="is_finance" type="radio"
                                                        id="finance-no" value="no">
                                                    <span class="text-muted">No</span></label>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="finance-show" style="display:none">
                                    <div class="col-4">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">Add information about it</label>
                                            <input type="text" class="form-control add_info" name="add_info" 
                                                placeholder="add information">
                                            <span class="text-red add_info_error" style="display:none;">This input field is required</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">Number of lease</label>
                                            <input type="text" class="form-control num_lease" name="num_lease" placeholder="Enter lease">
                                            <span class="text-red num_lease" style="display:none;">This input field is required</span>

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">LIEN details</label>
                                            <input type="text" class="form-control lien" name="lien" placeholder="lien code">
                                            <span class="text-red lien" style="display:none;">This input field is required</span>

                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger in_finance_error" style="display:none;">This field is required.</span>

                                <div class="control-group form-group">
                                    <label class="form-label mb-0">Is this vehicle a lease ?</label>
                                    <div class="form-group d-flex">
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control px-0 text-muted mb-0 tx-13">
                                                <label class="rdiobox p-0">
                                                <input type="hidden" name="" class="on_lease" id="on_lease_yes">

                                                    <input name="on_lease" type="radio"
                                                        id="on_lease" value="yes">
                                                    <span class="text-muted">Yes</span></label>

                                            </div>

                                        </div>
                                        <div class="checkbox">
                                            <div class="custom-checkbox custom-control text-muted mb-0 tx-13">
                                                <label class="rdiobox p-0"><input name="on_lease" type="radio"
                                                        id="question1-no" value="no">
                                                    <span class="text-muted">No</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <h3>Vehicle detail</h3>
                            <section>
                                <div class="control-group form-group">
                                    <label class="form-label mb-0">What type of vehicle is this for ?</label>
                                    <select name="veh_type" class="form-control form-select" id="veh_type" required
                                        data-bs-placeholder="Select ">
                                        <option selected disabled>chosse vehicle type</option>
                                        <option value="abc_vehicle">ABC vehiclae </option>
                                    </select>
                                </div>
                                <div class="control-group form-group">
                                    <label class="form-label mb-0">What is the full vehicle identification number
                                        ?</label>
                                    <input type="text" class="form-control" name="veh_id_num" id="veh_id_num" required
                                        placeholder="number">
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class=" row mb-4">
                                            <label class="col-md-4 form-label mb-0">Vehicle year </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="veh_year" id="veh_year"
                                                    required placeholder="year">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class=" row mb-4">
                                            <label class="col-md-4 form-label mb-0">Vehicel make</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="veh_make" id="veh_make"
                                                    required placeholder="make">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class=" row mb-4">
                                            <label class="col-md-4 form-label mb-0">Vehicle model</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="veh_model" id="veh_model"
                                                    required placeholder="model">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">What color is the vehicle ?</label>
                                            <select name="veh_color" class="form-control form-select" id="veh_color"
                                                required data-bs-placeholder="Select ">
                                                <option selected disabled>chosse color</option>
                                                <option value="abc_color">ABC color</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">How many miles are on the vehicle ?</label>
                                            <input type="number" class="form-control" name="veh_mile" id="veh_mile"
                                                required placeholder="miles">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">What is the total sale price ?</label>
                                            <input type="number" class="form-control" name="total_price"
                                                id="total_price" required placeholder="total price">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">Are there any trade-ins ?</label>
                                            <div class="form-group d-flex">
                                                <div class="checkbox">
                                                    <div
                                                        class="custom-checkbox custom-control px-0 text-muted mb-0 tx-13">
                                                        <label class="rdiobox p-0"><input name="trade_ins" type="radio"
                                                                id="amount-yes" value="yes">
                                                            <span class="text-muted">Yes</span></label>

                                                    </div>

                                                </div>
                                                <div class="checkbox">
                                                    <div class="custom-checkbox custom-control text-muted mb-0 tx-13">
                                                        <label class="rdiobox p-0"><input name="trade_ins" type="radio"
                                                                id="amount-no" value="no">
                                                            <span class="text-muted">No</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group form-group" id="amount-show" style="display:none">
                                            <input type="number" class="form-control" name="amount"
                                                placeholder="Enter amount">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">How much the vehicle weight ?</label>
                                            <input type="number" class="form-control" name="veh_weight" id="veh_weight"
                                                required placeholder="weight">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">How many cylinders have ?</label>
                                            <input type="number" class="form-control" name="cylinders" id="cylinders"
                                                required placeholder="cylinder">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">What type of fuel does it use ?</label>
                                            <input type="text" class="form-control" name="fuel_type" id="fuel_type"
                                                required placeholder="fuel">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">What is the gross weight ?</label>
                                            <input type="text" class="form-control" name="gross_weight"
                                                id="gross_weight" required placeholder="for tractors & commercials ">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <h3>Customer details</h3>
                            <section>
                                <div class="row">
                                    <label class="form-label mb-0">How many registrants are on this transaction
                                        ?</label>

                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <input type="text" class="form-control" name="registrant_1"
                                                id="registrant_1" required
                                                placeholder="Enter the name for registrant 1">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <input type="text" class="form-control" name="registrant_2"
                                                id="registrant_2" required
                                                placeholder="Enter the name for registrant 2">
                                        </div>
                                    </div>

                                    <label class="form-label mb-0">How many owner are on this transaction ?</label>

                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <input type="text" class="form-control" name="owner_1" id="owner_1" required
                                                placeholder="Enter the name for owner 1">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <input type="text" class="form-control" name="owner_2" id="owner_2" required
                                                placeholder="Enter the name for owner 2">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">Customer full social #</label>

                                            <input type="text" class="form-control" name="social" id="social" required
                                                placeholder="Enter social number">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">Is this transaction for a business or company
                                                ?
                                            </label>

                                            <div class="form-group d-flex">
                                                <div class="checkbox">
                                                    <div
                                                        class="custom-checkbox custom-control px-0 text-muted mb-0 tx-13">
                                                        <label class="rdiobox p-0">
                                                            <input name="transaction_for" type="radio" id="company-yes"
                                                                value="yes">
                                                            <span class="text-muted">Yes</span></label>

                                                    </div>

                                                </div>
                                                <div class="checkbox">
                                                    <div class="custom-checkbox custom-control text-muted mb-0 tx-13">
                                                        <label class="rdiobox p-0"><input name="transaction_for"
                                                                type="radio" id="company-no" value="no">
                                                            <span class="text-muted">No</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group form-group" style="display:none;"
                                                id="companyname">
                                                <label class="form-label mb-0">Company name</label>
                                                <input type="text" class="form-control" name="comapny_name"
                                                    id="compapny_name" required placeholder="enter comapny name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">what is the customer address ?</label>
                                            <textarea cols="30" rows="3" name="customer_address" id="customer_address"
                                                required class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">Address lane 2 ?</label>
                                            <textarea cols="30" rows="3" name="customer_address_2"
                                                id="customer_address_2" required class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">City</label>
                                            <input type="text" class="form-control" name="city" id="city" required
                                                placeholder="city">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">State</label>
                                            <input type="text" class="form-control" name="state" id="state" required
                                                placeholder="state">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="control-group form-group">
                                            <label class="form-label mb-0">Zip code</label>
                                            <input type="text" class="form-control" name="zip_code" id="zip_code"
                                                required placeholder="zip code">
                                        </div>
                                    </div>
                                </div>

                            </section>
                            <!-- <h3>Summary</h3>
                                <section>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Vehicle information</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td class="fw-bold">Vehicle type</td>
                                                                <td> Commercial</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Identification number</td>
                                                                <td>1234</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Vehicle year </td>
                                                                <td>2012</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Vehicle make</td>
                                                                <td> Toyota </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Vehicle model</td>
                                                                <td> 2015 </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Vehicle color </td>
                                                                <td> White </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Vehicle total miles</td>
                                                                <td> 1050 KM </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Vehicle sale price </td>
                                                                <td> $ 2000 </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Trade-ins </td>
                                                                <td> Yes ($ 1050) </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Vehicle weight </td>
                                                                <td> 105 KG </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Cylinders </td>
                                                                <td> 3</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Type of fuel that use </td>
                                                                <td> Petrol </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Gross weight </td>
                                                                <td> ... </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="card cart">
                                                <div class="card-header">
                                                    <h3 class="card-title">Transaction detail</h3>
                                                </div>
                                                <div class="card-body">

                                                    <ul class="list-group border br-7 mt-5">
                                                        <li class="list-group-item fw-bold border-0">
                                                            Reference number
                                                            <span class="h6  mb-0 float-end">DRL-1234</span>
                                                        </li>
                                                        <li class="list-group-item fw-bold border-0">
                                                            Transaction type
                                                            <span class="h6  mb-0 float-end">Registrration</span>
                                                        </li>
                                                        <li class="list-group-item fw-bold border-0">
                                                            Amount
                                                            <span class="h6  mb-0 float-end">$10</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="card cart">
                                                <div class="card-header">
                                                    <h3 class="card-title">Customer detail</h3>
                                                </div>

                                                <div class="card-body">
                                                    <div class="">
                                                        <h4 class="">Percy Kewshun</h4>
                                                        <p>4231 Bingamon Branch Road </p>
                                                        <p>Chicago, IL-60654</p>
                                                        <P>UTC-5: Eastern Standard Time (EST)</P>
                                                        <p class="mb-0">+125 254 3562 </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </section> -->

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!--/Row -->


</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
        $(document).on("click", '#finance-yes', function() {
            var val = document.getElementById('is_finance_yes').value = "yes";
        })

        $(document).on("click", '#finance-no', function() {
            var val = document.getElementById('is_finance_no').value = "no";
        })
        // form wizard        
        $('#wizard2').steps({
            headerTag: 'h3',
            bodyTag: 'section',
            autoFocus: true,
            titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
            onStepChanging: function (event, currentIndex, newIndex) {
                if (currentIndex < newIndex) {
                    // Step 1 form validation
                    if (currentIndex === 0) {
                        // return true;
                        var trans_state = $('#trans_state').parsley();
                        var trans_type = $('#trans_type').parsley();
                        var reg_type = $('#reg_type').parsley();
                        var is_finance = $('.is_finance').val();
                        var is_finance_yes = $('#is_finance_yes').val();

                        var add_info = $('.add_info').val();
                        var num_lease = $('.num_lease').val();
                        var lien = $('.lien').val();
                        if (trans_state.isValid() && trans_type.isValid() && reg_type.isValid() && is_finance !='') {
                            if(is_finance == 'no'){
                                $('.in_finance_error').css('display','none');
                            
                            return true;
                            }else if(is_finance_yes == 'yes' && add_info!='' && num_lease!='' && lien!='' )
                            {
                                $('.in_finance_error').css('display','none');
                                $('.add_info_error').css('display','none');
                                return true;
                            }
                        } else {
                            trans_state.validate();
                            trans_type.validate();
                            reg_type.validate();
                            if(is_finance == ''){
                                $('.in_finance_error').css('display','block');
                            }else{

                                $('.in_finance_error').css('display','none');
                            }
                            

                            if(is_finance_yes == 'yes' && add_info=='' && num_lease=='' && lien=='' )
                            {
                                // alert('hello')
                                $('.add_info_error').css('display','block');
                                
                            }
                            

                        }
                    }
                    // Step 2 form validation
                    if (currentIndex === 1) {
                        // return true;
                        var veh_type = $('#veh_type').parsley();
                        var veh_id_num = $('#veh_id_num').parsley();
                        var veh_year = $('#veh_year').parsley();
                        var veh_make = $('#veh_make').parsley();
                        var veh_model = $('#veh_model').parsley();
                        var veh_color = $('#veh_color').parsley();
                        var veh_mile = $('#veh_mile').parsley();
                        var total_price = $('#total_price').parsley();
                        var veh_weight = $('#veh_weight').parsley();
                        var cylinders = $('#cylinders').parsley();
                        var fuel_type = $('#fuel_type').parsley();
                        var gross_weight = $('#gross_weight').parsley();
                        if (veh_type.isValid() && veh_id_num.isValid() && veh_year.isValid() &&
                            veh_make.isValid() && veh_model.isValid() && veh_color.isValid() &&
                            veh_mile.isValid() && total_price.isValid() && veh_weight.isValid() &&
                            cylinders.isValid() && fuel_type.isValid() && gross_weight.isValid()) {
                            return true;
                        } else {
                            veh_type.validate();
                            veh_id_num.validate();
                            veh_year.validate();
                            veh_make.validate();
                            veh_model.validate();
                            veh_color.validate();
                            veh_mile.validate();
                            veh_weight.validate();
                            total_price.validate();
                            cylinders.validate();
                            fuel_type.validate();
                            gross_weight.validate();
                        }
                    }


                    // Always allow step back to the previous step even if the current step is not valid.
                } else {
                    return true;
                }
            },
            onFinished: function (event, currentIndex) {
                var registrant_1 = $('#registrant_1').parsley();
                var registrant_2 = $('#registrant_2').parsley();
                var owner_1 = $('#owner_1').parsley();
                var owner_2 = $('#owner_2').parsley();
                var social = $('#social').parsley();
                var customer_address = $('#customer_address').parsley();
                var customer_address_2 = $('#customer_address_2').parsley();
                var city = $('#city').parsley();
                var state = $('#state').parsley();
                var zip_code = $('#zip_code').parsley();
                if (registrant_1.isValid() && registrant_2.isValid() && owner_1.isValid() && owner_2
                    .isValid() && social.isValid() && customer_address.isValid() &&
                    customer_address_2.isValid() && city.isValid() && state.isValid() && zip_code
                    .isValid()) {
                    return true;
                } else {
                    registrant_1.validate();
                    registrant_2.validate();
                    owner_1.validate();
                    owner_2.validate();
                    social.validate();
                    customer_address.validate();
                    customer_address_2.validate();
                    city.validate();
                    state.validate();
                    zip_code.validate();;
                }
            }


        });

        // condition yes/No

        $("#company-yes").on('click', function (e) {
            $("#companyname").css('display', 'flex');
        })
        $("#company-no").on('click', function (e) {
            $("#companyname").hide();
        })

        $("#finance-yes").on('click', function (e) {
            $("#finance-show").css('display', 'flex');
        })
        $("#finance-no").on('click', function (e) {
            $("#finance-show").hide();
        })

        $("#amount-yes").on('click', function (e) {
            $("#amount-show").css('display', 'flex');
        })
        $("#amount-no").on('click', function (e) {
            $("#amount-show").hide();
        })
    })

</script>
<script>
    $(document).ready(function (e) {

        // add transaction
        $("#add_transaction").on('submit', (function (e) {
            // alert('hello'); 
            e.preventDefault();

            $.ajax({
                url: '/api/add/transaction',
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-pulse").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-pulse").css('display', 'none');
                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $("#add_transaction")[0].reset();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));
    });

</script>
@endsection
