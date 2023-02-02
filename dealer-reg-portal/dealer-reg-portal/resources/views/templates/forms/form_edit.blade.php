@extends('layouts.master')

@section('title')
Edit form
@endsection

@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">


    <!-- PAGE-HEADER Breadcrumbs-->
    <div class="page-header">
        <h1 class="page-title">Edit form</h1>
        <div>
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{url('/form/list')}}">Forms</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Edit form</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit form</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-12" id="drop_form" style="">
                        <form id="form_dropzone" action="/api/upload-file" class="dropzone" data-id="from_dropzone"
                            role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="fallback">
                                <input name="file" type="file" id="dropFile" />
                            </div>
                        </form>
                    </div>
                    <div class="form-group col-lg-12" id="drop_upload" style="">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="myTable" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <td>{{__('Uploaded Attachments')}}</td>
                                        </tr>
                                    </thead>

                                    <tbody id="uploadedFiles">
                                        @if($files != "Empty")
                                        @foreach($files as $file)
                                        <tr>
                                            <td><span><b>{{$file->name}}</b><br><small>Uploaded At:
                                                        {{$file->date}}|
                                                        Size: {{$file->size}} KB</small></span></td>
                                            <td><button type="button" id="{{$file->filename}}"
                                                    class="btnDeleteFile btn btn-sm btn-danger w-100"><i
                                                        class="fa fa-trash"></i></button> </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="update_form">
                    @csrf
                    <input type="hidden" name="id" id="{{$forms->id}}" value="{{$forms->id}}">
                            <input type="hidden" name="filesArr" id="filesArr" value="{{$forms->file}}">
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label mb-0">Form name :</label>
                            <input type="text" class="form-control" id="" name="form_name" value="{{$forms->form_name}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label mb-0">State :</label>
                            <select name="state" id="" class="form-select">
                                <option value="NY" {{$forms->state =='NY' ? 'selected':''}}>NY</option>
                                <option value="BY" {{$forms->state =='BY' ? 'selected':''}}>BY</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label mb-0">Message :</label>
                            <textarea name="message" id="" cols="30" rows="3" class="form-control">{{$forms->message}}</textarea>
                        </div>
                        <div class="form-group text-end  mb-0">
                        <button type="submit" class="btn btn-dealer btnSubmit" id="btnSubmit"> <i
                                    class="fa fa-spinner fa-pulse" style="display: none;"></i>
                                Save</button>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //DropZone
    Dropzone.autoDiscover = false;
    $(document).ready(function () {
        var files = '{{$forms->files}}'

        var filesUploaded = files == '' ? [] : JSON.parse('@php echo $forms->files; @endphp')
        var filesHtml = '';
        var validExtensions = [".pdf", ".PDF",];
        var myDropzone = new Dropzone("#form_dropzone", {
            parallelUploads: 1,
            uploadMultiple: false,
            timeout: 18000000,
            maxFilesize: 20, // MB
            maxFiles: 5,
            acceptedFiles: ".pdf,.PDF",
            addRemoveLinks: true,
            autoProcessQueue: true,
            init: function () {

                this.on('queuecomplete', function (file, response) {
                    // Here you can go to next form/route
                    uploadedFiles()
                })

                this.on("sending", function (file, xhr, formData) {
                    //console.log(file)
                })

                this.on("complete", function (file, response) {
                    //console.log(response)
                })

                this.on("success", function (file, response) {
                    this.removeFile(file);
                    //var res = JSON.parse(response)
                    if (response["status"] == "success") {
                        filesUploaded.push(response["file"]["file"]);
                    }
                })

                this.on("uploadprogress", function (file, progress, bytesSent) {
                    //console.log(file, progress, bytesSent)
                })

                this.on('errormultiple', function (file, response) {
                    // Here you can go to next form/route
                    //alert(response)
                })

                this.on('error', function (file, response) {
                    // Here you can go to next form/route
                    alert(response)
                    console.log(response)

                })
            },
            maxfilesreached: function (file) {
                $("#uploadError").html('Please upload max 5 file.');
            },
            maxfilesexceeded: function (file) {
                $("#uploadError").html('Please upload max 5 file.');
            },
            removedfile: function (file) {
                var fileName = file.name;
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file
                    .previewElement) : void 0;
            }
        });

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        $("#btnUpload").click(function (e) {
            e.preventDefault();
            $("#uploadError").hide();
            //$("#btnUpload").attr('disabled', true);
            if (myDropzone.getRejectedFiles().length == 0) {
                if (myDropzone.getAcceptedFiles().length == 0) {
                    $("#uploadError").show();
                    $("#uploadError").html('Please select files to upload.');
                } else {
                    $("#uploadError").hide();
                    for (var i = 0; i < myDropzone.getAcceptedFiles().length; i++) {
                        myDropzone.processFile(myDropzone.getAcceptedFiles()[i]);
                    }
                }
            } else {
                $("#uploadError").show();
                $("#uploadError").html('Please upload valid files.');
            }
        });

        function processDropzonePhotos() {
            $("#uploadError").hide();
            //$("#btnUpload").attr('disabled', true);

            console.log(myDropzone.getRejectedFiles().length)

            if (myDropzone.getRejectedFiles().length == 0) {
                if (myDropzone.getAcceptedFiles().length == 0) {
                    $("#uploadError").show();
                    $("#uploadError").html('Please select files to upload.');
                } else {
                    $("#uploadError").hide();
                    for (var i = 0; i < myDropzone.getAcceptedFiles().length; i++) {
                        myDropzone.processFile(myDropzone.getAcceptedFiles()[i]);
                    }
                }
            } else {
                $("#uploadError").show();
                $("#uploadError").html('Please upload valid files.');
            }
        }

        function uploadedFiles() {
            var html = '';
            if (filesUploaded.length > 0) {
                $.each(filesUploaded, (i, f) => {

                    html += '<tr>' +
                        '<td><span><b>' + f.name + '</b><br><small>Uploaded At: ' + f.date +
                        ' | Size: ' + formatBytes(f.size, decimals = 2) + '</small></span></td>' +
                        '<td><button type="button" id="' + f.filename +
                        '" class="btnDeleteFile btn btn-sm btn-danger w-100"><i class="fa fa-trash"></i></button> </td></tr>';
                })
                $("#uploadedFiles").empty()
                $("#uploadedFiles").html(html)

                $("#filesArr").val(JSON.stringify(filesUploaded))

            } else {
                $("#uploadedFiles").empty()
                $("#uploadedFiles").html('No files are uploaded yet')
                $("#filesArr").val('')
            }
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function removeUploadedFile(file) {
            var newArr = [];

            $.each(filesUploaded, (i, f) => {
                if (f.filename != file) {
                    newArr.push(f)
                }
            })

            filesUploaded = newArr;
            uploadedFiles()
        }
        $(document).on('click', '.btnDeleteFile', function (e) {
            var file = $(this).attr('id');
            console.log(file)
            Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to recover this File!",
                    type: "warning",
                    buttons: true,
                    confirmButtonColor: "#ff5e5e",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    dangerMode: true
                })
                .then((deleteThis) => {
                    if (deleteThis) {
                        $.ajax({
                            url: '/api/delete-file',
                            type: "delete",
                            dataType: "JSON",
                            data: {
                                file: file,
                            },
                            success: function (response) {
                                if (response["status"] == "fail") {
                                    Swal.fire("Failed!", "Failed to delete file.",
                                        "error");
                                } else if (response["status"] == "success") {
                                    Swal.fire("Deleted!", "File has been deleted.",
                                        "success");
                                    removeUploadedFile(file)

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
        $("#thumbnail").on('change', (function (e) {
            photoError = 0;
            if (e.target.files && e.target.files[0]) {
                // console.log(e.target.files[0].name.strtolower())
                if (e.target.files[0].name.match(/\.(jpg|jpeg|JPG|png|gif|PNG)$/)) {
                    $("#photo-error").empty();
                    photoError = 0;
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#user_photo_selected').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files[0]);

                } else {
                    photoError = 1;
                    $("#photo-error").empty();
                    $("#photo-error").append(
                        '<p class="text-danger">Please upload only jpg, png format!</p>');
                }
            } else {
                $('#user_photo_selected').attr('src', '');
            }

            if (photoError == 0) {
                $(".btn-change-photo").prop('disabled', false);
                $("#btnSubmit").attr('disabled', false);
            } else {
                $(".btn-change-photo").prop('disabled', true);
                $("#btnSubmit").attr('disabled', true);
            }
        }));

        $("#btnSubmit").on('click', (function (e) {

            $("#update_form").submit()
        }));

        $("#update_form").on('submit', (function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '/api/update/form',
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $("#btnSubmit").attr('disabled', true);
                    $(".fa-spin").css('display', 'inline-block');
                },
                complete: function () {
                    $("#btnSubmit").attr('disabled', false);
                    $(".fa-spin").css('display', 'none');
                }, 
                success: function (response) {
                    // console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        toastr.success('Success', response["msg"])
                        $("#update_form")[0].reset();
                        window.location.href = "{{'/form/list'}}";
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
