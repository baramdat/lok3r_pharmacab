@extends('layouts.master')

@section('title')
Edit transaction
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Edit transaction</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Edit transaction</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

   <!-- CONTAINER -->
<div class="main-container container-fluid">



<!-- Row -->
<div class="row ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-bottom-0">
                <div class="card-title">
                    Edit transaction
                </div>
            </div>
            <div class="card-body">
                <form action="" id="add_transaction">
                    <div id="wizard1">
                        @csrf
                        <h3>Transaction detail</h3>
                        <section>
                            <div class="control-group form-group">
                                <label class="form-label mb-0">What state is this transaction for ?</label>
                                <select name="trans_state" class="form-control form-select" data-bs-placeholder="">
                                    <option selected disabled>chosse state</option>
                                    <option value="abc_state">ABC state </option>
                                </select>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label mb-0">What type of transaction is this for ?</label>
                                <select name="trans_type" class="form-control form-select" data-bs-placeholder="">
                                    <option selected disabled>chosse transaction type</option>
                                    <option value="trans_type ">ABC transaction type</option>
                                </select>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label mb-0">What type of registration is this for ?</label>
                                <select name="reg_type" class="form-control form-select" data-bs-placeholder="">
                                    <option selected disabled>chosse transaction type</option>
                                    <option value="reg_type">Registration type</option>
                                </select>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label mb-0">Is this vehicle being financed ?</label>
                                <div class="form-group d-flex">
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control px-0 text-muted mb-0 tx-13">
                                            <label class="rdiobox p-0"><input name="is_finance" type="radio"
                                                    id="finance-yes" value="yes">
                                                <span class="text-muted">Yes</span></label>

                                        </div>

                                    </div>
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control text-muted mb-0 tx-13">
                                            <label class="rdiobox p-0"><input name="is_finance" type="radio"
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
                                        <input type="text" class="form-control" name="add_info"
                                            value="{{$transaction->add_info}}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">Number of lease</label>
                                        <input type="text" class="form-control" name="num_lease" placeholder="city">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">LIEN details</label>
                                        <input type="text" class="form-control" name="lien" placeholder="lien code">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label mb-0">Is this vehicle a lease ?</label>
                                <div class="form-group d-flex">
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control px-0 text-muted mb-0 tx-13">
                                            <label class="rdiobox p-0"><input name="on_lease" type="radio"
                                                    id="question1-yes" value="yes">
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
                                <select name="veh_type" class="form-control form-select"
                                    data-bs-placeholder="Select ">
                                    <option selected disabled>chosse vehicle type</option>
                                    <option value="abc_vehicle">ABC vehiclae </option>
                                </select>
                            </div>
                            <div class="control-group form-group">
                                <label class="form-label mb-0">What is the full vehicle identification number
                                    ?</label>
                                <input type="text" class="form-control" name="veh_id_num" placeholder="number">
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class=" row mb-4">
                                        <label class="col-md-4 form-label mb-0">Vehicle year </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="veh_year" placeholder="year">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class=" row mb-4">
                                        <label class="col-md-4 form-label mb-0">Vehicel make</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="veh_make" placeholder="make">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class=" row mb-4">
                                        <label class="col-md-4 form-label mb-0">Vehicle model</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="veh_model" placeholder="model">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">What color is the vehicle ?</label>
                                        <select name="veh_color" class="form-control form-select"
                                            data-bs-placeholder="Select ">
                                            <option selected disabled>chosse color</option>
                                            <option value="abc_color">ABC color</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">How many miles are on the vehicle ?</label>
                                        <input type="number" class="form-control" name="veh_mile"
                                            placeholder="miles">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">What is the total sale price ?</label>
                                        <input type="number" class="form-control" name="total_price"
                                            placeholder="total price">
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
                                        <input type="number" class="form-control" name="veh_weight"
                                            placeholder="weight">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">How many cylinders have ?</label>
                                        <input type="number" class="form-control" name="cylinders"
                                            placeholder="cylinder">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">What type of fuel does it use ?</label>
                                        <input type="text" class="form-control" name="fuel_type" placeholder="fuel">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">What is the gross weight ?</label>
                                        <input type="text" class="form-control" name="gross_weight"
                                            placeholder="for tractors & commercials ">
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
                                            placeholder="Enter the name for registrant 1">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <input type="text" class="form-control" name="registrant_2"
                                            placeholder="Enter the name for registrant 2">
                                    </div>
                                </div>

                                <label class="form-label mb-0">How many owner are on this transaction ?</label>

                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <input type="text" class="form-control" name="owner_1"
                                            placeholder="Enter the name for owner 1">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <input type="text" class="form-control" name="owner_2"
                                            placeholder="Enter the name for owner 2">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">Customer full social #</label>

                                        <input type="text" class="form-control" name="social"
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
                                                placeholder="enter comapny name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">what is the customer address ?</label>
                                        <textarea  cols="30" rows="3" name="customer_address"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">Address lane 2 ?</label>
                                        <textarea  cols="30" rows="3" name="customer_address_2"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">City</label>
                                        <input type="text" class="form-control" name="city" placeholder="city">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">State</label>
                                        <input type="text" class="form-control" name="state" placeholder="state">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="control-group form-group">
                                        <label class="form-label mb-0">Zip code</label>
                                        <input type="text" class="form-control" name="zip_code" placeholder="zip code">
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

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
        // form wizard
        $('#wizard1').steps({
            headerTag: 'h3',
            bodyTag: 'section',
            autoFocus: true,
            titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
            onFinished: function(event,currentIndex){
                $("#add_transaction").submit();

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

@endsection
