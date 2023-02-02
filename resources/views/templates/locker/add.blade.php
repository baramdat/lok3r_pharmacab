@extends('layouts.master')

@section('title')
Add locker
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Add locker</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/locker/list')}}">Lockers</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Add Locker</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add locker</h3>
            </div>
            <div class="card-body">
                <form id="add_form">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Locker No: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="number" name="number" placeholder="LS-001" required>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <?php
                            $sizesArr = App\Models\LockerSize::all();                            
                            ?>
                            <label class="form-label mb-0">Size:</label>
                            <select class="form-select" name="size_id" id="size_id" required>
                                <option value="">choose size</option>
                                @foreach ($sizesArr as $size)
                                    <option value="{{$size->id}}">{{$size->size}}</option>
                                @endforeach                                
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Row: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="row" name="row" placeholder="" required>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Column: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="column" name="column" placeholder="" required>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <?php
                            $sitesArr = App\Models\Site::all();  
                            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                                $sitesArr = App\Models\Site::where('id',Auth::user()->site->id)->get();
                            }                          
                            ?>
                            <label class="form-label mb-0">Site:</label>
                            <select class="form-select" name="site_id" id="site_id" required>
                                <option value="">choose site</option>
                                @foreach ($sitesArr as $site)
                                    <option value="{{$site->id}}">{{ucwords($site->name)}}</option>
                                @endforeach                                
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label class="form-label mb-0">Relay #: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="relay" name="relay" placeholder="" min="1" required>
                        </div>
                        
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="" class="form-label mb-0">Comment :</label>
                            <textarea name="comment" id="comment" cols="30" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="form-group col-lg-12 col-sm-12 text-center">
                            <button type="submit" class="btn btn-dealer w-25 btnSubmit" id="btnSubmit"> 
                                <i class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                Save
                            </button>
                        </div>                        
                    </div>                
                </form>
            </div>
        </div>
    </div>

</div>
<!-- CONTAINER END -->
@endsection

@section('bottom-script')
<script>
    $(document).ready(function (e) {
        // add forms
        $("#add_form").on('submit', (function (e) {
            
            e.preventDefault();

            $.ajax({
                url: '/api/locker/add',
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
                        $("#add_form")[0].reset();
                    }
                },
                error: function (error) {
                    // console.log(error);
                }
            });
        }));
    });

</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
