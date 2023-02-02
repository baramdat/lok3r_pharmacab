@extends('layouts.master')

@section('title')
Pricing History
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">

    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <div>
            <h1 class="page-title">Pricing History</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/pricing')}}">Pricing</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Pricing History</li>
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
                            <h6 class="mb-0 mt-1 text-muted">Lockers Pricing History</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="grid-margin">
                        <div class="">
                            <div class="panel panel-primary">
                                <div class="panel-body tabs-menu-body border-0 pt-0">
                                    <div class="table-responsive">
                                        <table id="history-datatable" class="table table-bordered text-nowrap mb-0">
                                            <thead class="border-top">
                                                <tr>
                                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">
                                                        ID</th>
                                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">
                                                        Date</th>
                                                    <th class="bg-transparent border-bottom-0">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tBody">

                                            </tbody>
                                        </table>
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

        var table = $('#history-datatable').DataTable();
        var pageInfo = table.page.info();

        getHistory()
        function getHistory() {
            datatable('');
            $.ajax({
                url: '/api/pricing/history',
                type: "get",
                dataType: "JSON",
                cache: false,
                success: function (response) {
                    console.log(response)
                    if (response["status"] == "fail") {                        
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        datatable(response["rows"]);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        $(document).on('click', '.btnDelete', function (e) {
            pageInfo = table.page.info();
            var id = $(this).attr('id')
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this history!",
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
                        url: '/api/pricing/history/delete/' + id,
                        type: "delete",
                        dataType: "JSON",
                        success: function (response) {
                            if (response["status"] == "fail") {
                                Swal.fire("Failed!", "Failed to delete pricing history.",
                                    "error");
                            } else if (response["status"] == "success") {
                                Swal.fire("Deleted!", "Pricing history has been deleted.",
                                    "success");
                                getHistory()
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        },
                        async: false
                    });
                } else {
                    Swal.close();
                }
            });
        });

        function datatable(rows) {
            $("#history-datatable tbody").empty();
            $("#history-datatable").DataTable().clear();
            $("#history-datatable").DataTable().destroy();
            $("#tBody tr").remove();
            $("#history-datatable tbody").empty();
            $("#tBody").append(rows);
            table = $("#history-datatable").DataTable();
            table.page(pageInfo.page).draw(false)
        }

    });

</script>
@endsection
 