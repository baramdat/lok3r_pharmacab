@extends('layouts.master')

@section('title')
Users list
@endsection

@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <div>
        <h1 class="page-title">Users List</h1>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">User list</li>
            </ol>
        </div>
        @if(Auth::user()->hasRole('Site Admin'))
        <a role="button" class="btn btn-dealer" href="{{url('/user/add')}}">
                <span class="fe fe-user-plus fs-14"></span> Add user</a>
        @endif
    </div> 
    <!-- PAGE-HEADER END -->
    <!-- filters -->
    <div class="card">
        <div class="card-body px-3 py-2 pt-3">
            <div class="form-row align-items-center">
                <div class="col-6 col-lg-6 mb-1">
                    <label for="" class="fw-bold mb-1">Search by name:</label>
                    <input type="text" id="search" class="form-control" placeholder="search by name....">
                </div>
                <div class="col-6 col-lg-2 mb-1">
                    <?php
                        $rolesArr = \Spatie\Permission\Models\Role::all(); 
                        if(Auth::user()->hasRole('Site Admin')){
                            $rolesArr = \Spatie\Permission\Models\Role::where('id',2)->orWhere('id',3)->get(); 
                        }

                        if(Auth::user()->hasRole('Staff')){
                            $rolesArr = \Spatie\Permission\Models\Role::where('id',3)->get(); 
                        }
                    ?>
                    <label for="" class="fw-bold mb-1">Search by role:</label>
                    <select class="form-control form-select" id="filterRole">
                        <option value="All" selected>All</option>
                        @foreach($rolesArr as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select> 
                </div>
                <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="mb-1"></label>

                    <button id="btnFilter" type="button" class="btn btn-dealer btn-block">Filter</button>
                </div>
                <div class="col-6 col-lg-2 mb-1">
                    <label for="" class="mb-1"></label>

                    <button id="btnReset" type="button" class="btn btn-outline-info btn-block">Reset</button>
                </div>
                
            </div>
        </div>
    </div>

    <div class="row" id="divData">

    </div>



    <div id="divLoader" class="text-center pt-5" style="display:block;height:300px;">
        <span>
            <i class="bx bx-loader-circle bx-spin"></i> {{__('User are being loading.. It might take few seconds')}}.
        </span>
    </div>
    <div class="row text-center" id="divNotFound" style="display:none">
        <h6 class="mt-lg-5" style=""><i class="bx bx-window-close"></i> {{__('No User Found')}} !</h6>
    </div>
    <!-- pagination -->
    <div class="row mb-5">
        <div class="col-12">
            <div id="divPagination" class="">
                <ul id="content-pagination" class="pagination-sm justify-content-end" style="display:none;"></ul>
            </div>
        </div>
    </div>
</div>
@endsection


@section("bottom-script")
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function (e) {
        var filterLength = 1;
        var total = 0;
        var filterTitle = $("#search").val();
        var contentPagination = $("#content-pagination");
        var contentNotFound = $("#divNotFound");
        var contentFound = $("#divData");
        var filterRole = $("#filterRole").val();

        function setFilters() {
            filterTitle = $("#search").val() 
            filterRole = $("#filterRole").val()

            filterLength = 10;
        }
        userCount();

        function userCount() {
            setFilters()
            $("#divData").html(''); 
            contentPagination.twbsPagination('destroy');
            $.ajax({
                url: '/api/user/count/',
                type: "get",
                data: {
                    filterTitle: filterTitle,
                    filterLength: filterLength,
                    filterRole: filterRole,
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
                    } else if (response["status"] == "fail") {
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

        function users(offset, filterLength) {
            setFilters()
            $("#content-pagination").css('display', 'none')

            $("#divData").html('')
            $("#divLoader").css('display', 'block')
            $("#divData").css('display', 'none')
            $("#divNotFound").css('display', 'none')

            $.ajax({
                url: '/api/users/',
                type: "get",
                data: {
                    filterTitle: filterTitle,
                    filterLength: filterLength,
                    offset: offset,
                    filterRole: filterRole,
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
                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'none')
                        $("#divNotFound").css('display', 'block')
                    } else if (response["status"] == "success") {
                        $("#divNotFound").css('display', 'none')
                        $("#divLoader").css('display', 'none')
                        $("#divData").css('display', 'flex')
                        $("#divData").html('');
                        $("#divData").append(response["rows"])
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
                        users((page === 1 ? page - 1 : ((page - 1) * filterLength)), filterLength);
                    }
                });
            } else {
                contentPagination.hide();
                contentFound.hide();
                contentNotFound.show();
            }
        }

        $(document).on('keyup', '#search', function () {
            $("#divData").html('');
            setFilters()
            contentPagination.twbsPagination('destroy');
            userCount()
        });
        $(document).on('click', '#btnFilter', function (e) {
            setFilters()
            $("#divData").html('')
            contentPagination.twbsPagination('destroy');
            userCount()
        })


        $(document).on('click', '#btnReset', function (e) {
            $("#search").val('')
            $("#filterRole").val('All')
            $("#filterType").val('All')
            setFilters()
            $("#divData").html('')
            contentPagination.twbsPagination('destroy');
            userCount()
        })



        $(document).on('click', '.btnDelete', function (e) {
            var id = $(this).attr('id')
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this User!",
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
                        url: '/api/delete/user/' + id,
                        type: "delete",
                        dataType: "JSON",
                        success: function (response) {

                            if (response["status"] == "fail") {
                                Swal.fire("Failed!", "Failed to delete User.",
                                    "error");
                            } else if (response["status"] == "success") {
                                Swal.fire("Deleted!", "User has been deleted.",
                                    "success");
                                userCount()
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

        // edit user
        $(document).on('click', '.btnEdit', function (e) {
            var role = $(this).attr('id');
            $.ajax({
                url: '/api/edit/user/' + id,
                type: "GET",
                dataType: "JSON",
                data: {
                    role: role

                },
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        // toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        // toastr.success('Success', response["msg"])
                        $("#name").val(response["data"]["name"])
                        $("#role_id").val(response["data"]["id"])
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
