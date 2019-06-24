<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin Free Bootstrap Admin Dashboard Template</title>
    <!-- plugins:css-->
    <link rel="stylesheet" href="<?=PUBLIC_URL?>admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>admin/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>admin/vendors/css/vendor.bundle.addons.css">
    <!-- endinject-->
    <!-- plugin css for this page-->
    <!-- End plugin css for this page-->
    <!-- inject:css-->
    <link rel="stylesheet" href="<?=PUBLIC_URL?>admin/css/style.css">
    <!-- endinject-->
    <link rel="shortcut icon" href="<?=PUBLIC_URL?>admin/images/favicon.png">
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auto-form-wrapper">
                        <form method="POST">
                            <div class="form-group"><label class="label">Username</label>
                                <div class="input-group"><input class="form-control" type="text" name="username" placeholder="Username">
                                    <div class="input-group-append"><span class="input-group-text"><i class="mdi mdi-check-circle-outline"></i></span></div>
                                </div>
                            </div>
                            <div class="form-group"><label class="label">Password</label>
                                <div class="input-group"><input class="form-control" type="password" name="password" placeholder="*********">
                                    <div class="input-group-append"><span class="input-group-text"><i class="mdi mdi-check-circle-outline"></i></span></div>
                                </div>
                            </div>
                            <div class="form-group"><button class="btn btn-primary submit-btn btn-block">Login</button></div>
                            <div class="form-group"><button class="btn btn-block g-login"><!--img.mr-3(src='/admin/images/samples/weather.svg', alt='')-->Log in with Google</button></div>
                        </form>
                    </div>
                    <ul class="auth-footer">
                        <li><a href="#">Conditions</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Terms</a></li>
                    </ul>
                    <p class="footer-text text-center">copyright © 2018 Bootstrapdash. All rights reserved.</p>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends-->
        <!-- page-body-wrapper ends-->
        <!-- container-scroller-->
        <!-- plugins:js-->
        <script src="<?=PUBLIC_URL?>admin/vendors/js/vendor.bundle.base.js"></script>
        <script src="<?=PUBLIC_URL?>admin/vendors/js/vendor.bundle.addons.js"></script>
        <!-- endinject-->
        <!-- inject:js-->
        <script src="<?=PUBLIC_URL?>admin/js/off-canvas.js"></script>
        <script src="<?=PUBLIC_URL?>admin/js/misc.js"></script>
        <!-- endinject-->
    </div>
</div>
</body>

</html>