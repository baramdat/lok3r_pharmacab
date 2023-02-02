@extends('layouts.master')

@section('title')
Transaction Detail
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Transaction Detail</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Transaction Detail</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header  mx-1">
                    <div class="media">
                        <div class="media-body">
                            <h6 class="mb-0 mt-1 text-muted">Transaction detail</h6>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-bottom detail">
                                                    <td class="text-center">
                                                        <div class="mt-0 mt-sm-2 d-block">
                                                            <h6 class="mb-0 fs-14 ">
                                                                DRL-1234</h6>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="ms-3 mt-0 mt-sm-2 d-block">
                                                            <h6 class="mb-0 fs-14 ">
                                                                Jhon Doe</h6>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="mt-0 mt-sm-3 d-block">
                                                                <h6 class="mb-0 fs-14 ">
                                                                    NY</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="mt-sm-2 d-block">Lien Correction</span></td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group border mt-5">
                        <li class="list-group-item border-0">
                            Registration fee
                            <span class="h6 fw-bold mb-0 float-end">$360</span>
                        </li>
                        <li class="list-group-item border-0">
                            Sales tax
                            <span class="h6 fw-bold mb-0 float-end">$5</span>
                        </li>
                        <li class="list-group-item border-0">
                            Shipping fee
                            <span class="h6 fw-bold mb-0 float-end">$20</span>
                        </li>
                        <li class="list-group-item border-0">
                            Technology fee
                            <span class="h6 fw-bold mb-0 float-end">$15</span>
                        </li>
                        <li class="list-group-item border-0">
                            Service fee
                            <span class="h6 fw-bold mb-0 float-end">$90</span>
                        </li>
                        <li class="list-group-item border-0">
                            Total
                            <span class="h4 fw-bold mb-0 float-end">$3,976</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Information</h3>
                </div>
                <div class="card-body">
                    <div class="card-pay">
                        <ul class="tabs-menu nav">
                            <li class=""><a href="#tab20" class="payment-icon active" data-bs-toggle="tab"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                        <path
                                            d="M19.5,5h-15C3.119812,5.0012817,2.0012817,6.119812,2,7.5v10c0.0012817,1.380188,1.119812,2.4987183,2.5,2.5h15c1.380188-0.0012817,2.4987183-1.119812,2.5-2.5v-10C21.9987183,6.119812,20.880188,5.0012817,19.5,5z M21,17.5c-0.0009155,0.828064-0.671936,1.4990845-1.5,1.5h-15c-0.828064-0.0009155-1.4990845-0.671936-1.5-1.5V11h18V17.5z M21,10H3V7.5C3.0009155,6.671936,3.671936,6.0009155,4.5,6h15c0.828064,0.0009155,1.4990845,0.671936,1.5,1.5V10z M6.5,15h4c0.276123,0,0.5-0.223877,0.5-0.5S10.776123,14,10.5,14h-4C6.223877,14,6,14.223877,6,14.5S6.223877,15,6.5,15z" />
                                        </svg> Credit Card</a></li>
                            <li><a href="#tab21" data-bs-toggle="tab" class="payment-icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                        <path
                                            d="M19.6542969,7.5869141c-0.2009888-0.2196655-0.4307251-0.4111938-0.6829224-0.569397c0.2329712-1.2444458-0.1186523-2.5269165-0.9537964-3.4784546c-0.9375-1.0605469-2.5751953-1.5986328-4.8681641-1.5986328H7.2646484c-0.6590576,0.0014038-1.2197266,0.480957-1.3232422,1.1318359l-2.453125,15.5898438c-0.0911865,0.5485229,0.279541,1.0670776,0.828064,1.1582642c0.0548706,0.0090942,0.1104126,0.0136719,0.1660767,0.0136108h3.0460815l-0.1593628,1.0136719c-0.0817261,0.5153809,0.2698364,0.9993896,0.7852173,1.0811157c0.0480957,0.0076294,0.0967407,0.0115356,0.1454468,0.0116577h3.0634766c0.6047363,0.0022583,1.12146-0.4353638,1.218689-1.0322266l0.6065063-3.8271484l0.0409546-0.2167969c0.0169067-0.1159668,0.116272-0.2019653,0.2333984-0.2021484h0.4580078c3.6289062,0,5.8027344-1.7197266,6.4619141-5.1123047C20.7811279,10.1879883,20.5109253,8.7180176,19.6542969,7.5869141z M7.8912964,17.5264893l-0.2067261,1.3065186l-3.2089844-0.0107422L6.9296875,3.2236328c0.0270996-0.1637573,0.1690063-0.2837524,0.335022-0.2832031h5.8847656c1.9941406,0,3.3798828,0.4238281,4.1162109,1.2587891c0.7022095,0.8255005,0.9553833,1.942627,0.6777344,2.9902344l0.0020752,0.0003052l-0.0001221,0.0006714c-0.0166016,0.1054688-0.0351562,0.2138672-0.0566406,0.3251953l-0.0010376,0.0029297c-0.6494141,3.3476562-2.7207031,4.9755859-6.3330078,4.9755859H9.8271484c-0.661499-0.0014648-1.2243652,0.4816284-1.3232422,1.1357422L7.8912964,17.5264893z M19.4003906,11.359375c-0.5625,2.8955078-2.3544922,4.3027344-5.4794922,4.3027344h-0.4580078c-0.6051636-0.0033569-1.1224976,0.4347534-1.21875,1.0322266l-0.6152344,3.8729858l-0.0322266,0.1708984c-0.017334,0.1160889-0.1170044,0.2020874-0.234375,0.2021484l-3.0048828,0.0644531l0.6048584-3.8487549l0.5338135-3.3699951l-0.0040894-0.0006104l0.0001831-0.0012817c0.024353-0.1663208,0.1668701-0.2897339,0.335022-0.289978h1.7275391c3.9599609,0,6.3896484-1.8076172,7.2275391-5.375c0.0419922,0.0410156,0.0820312,0.0830078,0.1201172,0.1259766C19.5513916,9.1461182,19.7360229,10.3009644,19.4003906,11.359375z" />
                                        </svg> ACH</a></li>
                            <li><a href="#tab22" data-bs-toggle="tab" class="payment-icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                        <path
                                            d="M21.6728516,4.53125l-9.5-3.5c-0.1115723-0.0410156-0.2341309-0.0410156-0.3457031,0l-9.5,3.5C2.1305542,4.6034546,1.999939,4.7905884,2,5v3.5C1.9998169,8.776001,2.2234497,8.9998169,2.4993896,9C2.4996338,9,2.4998169,9,2.5,9H4v8.0505371C2.836792,17.2893677,2.0013428,18.3125,2,19.5v2c-0.0001831,0.276001,0.2234497,0.4998169,0.4993896,0.5C2.4996338,22,2.4998169,22,2.5,22h19c0.276001,0.0001831,0.4998169-0.2234497,0.5-0.4994507c0-0.0001831,0-0.0003662,0-0.0005493v-2c-0.0013428-1.1875-0.836792-2.2106323-2-2.4494629V9h1.5c0.276001,0.0001831,0.4998169-0.2234497,0.5-0.4994507C22,8.5003662,22,8.5001831,22,8.5V5C22.000061,4.7905884,21.8694458,4.6034546,21.6728516,4.53125z M21,19.5V21H3v-1.5c0.0009155-0.828064,0.671936-1.4990845,1.5-1.5h15C20.328064,18.0009155,20.9990845,18.671936,21,19.5z M5,17V9h3v8H5z M9,17V9h6v8H9z M16,17V9h3v8H16z M21,8H3V5.3486328l9-3.3154297l9,3.3154297V8z" />
                                        </svg> Mail in check</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab20">
                                <div class="bg-danger-transparent-2 text-danger br-3 mb-4" role="alert">Please Enter
                                    Valid Details</div>
                                <div class="form-group">
                                    <label class="form-label">CardHolder Name</label>
                                    <input type="text" class="form-control" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Card number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-text input-text-color">
                                            <i class="fa fa-cc-visa text-muted"></i> &nbsp; <i
                                                class="fa fa-cc-amex text-muted"></i> &nbsp;
                                            <i class="fa fa-cc-mastercard text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label class="form-label">Expiration</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="MM" name="Month">
                                                <input type="number" class="form-control" placeholder="YY" name="Year">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">CVV <i class="fa fa-question-circle"></i></label>
                                            <input type="number" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" class="btn  btn-lg btn-primary">Confirm</a>
                            </div>
                            <div class="tab-pane" id="tab21">
                            <div class="bg-danger-transparent-2 text-danger br-3 mb-4" role="alert">Please Enter
                                    Valid Details</div>
                                
                                <div class="form-group">
                                    <label class="form-label">Card number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-text input-text-color">
                                            <i class="fa fa-cc-visa text-muted"></i> &nbsp; <i
                                                class="fa fa-cc-amex text-muted"></i> &nbsp;
                                            <i class="fa fa-cc-mastercard text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ROuting number</label>
                                    <input type="text" class="form-control" placeholder="First Name">
                                </div>
                                <a href="javascript:void(0)" class="btn  btn-lg btn-primary">Confirm</a>
                            </div>
                            <div class="tab-pane" id="tab22">
                                <p>Bank account details</p>
                                <dl class="card-text">
                                    <dt>BANK: </dt>
                                    <dd> THE UNION BANK 0456</dd>
                                </dl>
                                <dl class="card-text">
                                    <dt>Account Number: </dt>
                                    <dd> 67542897653214</dd>
                                </dl>
                                <dl class="card-text">
                                    <dt>IBAN: </dt>
                                    <dd>543218769</dd>
                                </dl>
                                <p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit
                                    aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                                    voluptatem sequi nesciunt. </p>
                            </div>
                        </div>
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
    $(document).ready(function (e) {

    })

</script>

@endsection
