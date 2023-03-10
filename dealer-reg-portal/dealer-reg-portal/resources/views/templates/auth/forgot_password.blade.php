<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Buzono – Buzono">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/brand/LOGO-FINAL.JPEG')}}" />


    <!-- TITLE -->
    <title>Forgot password – Buzono</title>

    <!-- BOOTSTRAP CSS -->
    @include('includes.style')

</head>

<body class="app sidebar-mini ltr">

    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">

        <!-- GLOABAL LOADER -->
        <div id="global-loader">
            <img src="{{asset('assets/images/loader.svg')}}" class="loader-img" alt="Loader">
        </div>
        <!-- End GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">

                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto">
                    <div class="text-center">
                        <img src="{{asset('assets/images/brand/LOGO-FINAL.JPEG')}}" class="header-brand-img" alt=""
                            style="height:59px !important; width:137px !important;">
                    </div>
                </div>

                <!-- CONTAINER OPEN -->
                <div class="container-login100">
                    <div class="wrap-login100 p-6">
                        <form class="login100-form validate-form" id="forget_password">
                            <span class="login100-form-title pb-5" >
                                Forgot Password
                            </span>
                            <p class="text-muted">Enter the email address to reset password. </p>
                            <div id="email"  class="wrap-input100 validate-input input-group"
                                data-bs-validate="Valid email is required: ex@abc.xyz">
                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                    <i class="zmdi zmdi-email" aria-hidden="true"></i>
                                </a>
                                <input class="input100 border-start-0 ms-0 form-control" type="email" name="email" required
                                    placeholder="Email">
                            </div>
                            <div class="submit">
                                <button type="submit" class="btn btn-primary btnSubmit" id="btnSubmit">
                                    <i class="fa fa-spinner fa-pulse" style="display: none;"></i> Send Email
                                </button>
                            </div>
                            <div class="text-center mt-4">
                                <p class="text-dark mb-0">Remember it?<a class="text-primary ms-1"
                                        href="{{url('/login')}}">Send me back</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--END PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE CLOSED -->

    @include('includes.script')
    <script type="text/javascript">
        $("#forget_password").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '/api/forget/password',
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
                    console.log(response);
                    if (response["status"] == "fail") {
                        toastr.error('Failed', response["msg"])
                    } else if (response["status"] == "success") {
                        $("#email").css('display', 'none')
                        $("#btnSubmit").css('display', 'none')
                        $("#emalLabel").css('display', 'none')
                        toastr.success('Success', response["msg"])
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }));

    </script>

</body>

</html>
