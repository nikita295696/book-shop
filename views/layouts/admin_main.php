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
    <link rel="stylesheet" href="<?=PUBLIC_URL?>stylesheets/bootstrap.css">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>stylesheets/bootstrap-grid.min.css">
    <link rel="stylesheet" href="<?=PUBLIC_URL?>stylesheets/bootstrap-reboot.min.css">
    <script src="<?=PUBLIC_URL?>javascripts/public.js"></script>
    <script src="<?=PUBLIC_URL?>javascripts/jquery-3.3.1.min.js"></script>
    <script src="<?=PUBLIC_URL?>javascripts/glm-ajax.js"></script>
    <script src="<?=PUBLIC_URL?>javascripts/bootstrap.min.js"></script>
    <script src="<?=PUBLIC_URL?>javascripts/bootstrap.bundle.min.js"></script>
</head>


<body>
<div class="container-scroller"><!-- partial:partials/_navbar.html-->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center"><a
                class="navbar-brand brand-logo" href="/"><img src="<?=PUBLIC_URL?>admin/images/logo.svg" alt="logo"></a><a
                class="navbar-brand brand-logo-mini" href="index.html"><img src="<?=PUBLIC_URL?>admin/images/logo-mini.svg"
                                                                            alt="logo"></a></div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex"></ul>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown d-none d-xl-inline-block"><a class="nav-link dropdown-toggle"
                                                                          id="UserDropdown" href="#"
                                                                          data-toggle="dropdown"
                                                                          aria-expanded="false"><span
                            class="profile-text">Hello, admin !</span><img class="img-xs rounded-circle"
                                                                           src="<?=PUBLIC_URL?>admin/images/faces/face1.jpg"
                                                                           alt="Profile image"></a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown"><a
                            class="dropdown-item p-0">
                            <div class="d-flex border-bottom">
                                <div class="py-3 px-4 d-flex align-items-center justify-content-center"><i
                                        class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i></div>
                                <div
                                    class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                                    <i class="mdi mdi-account-outline mr-0 text-gray"></i></div>
                                <div class="py-3 px-4 d-flex align-items-center justify-content-center"><i
                                        class="mdi mdi-alarm-check mr-0 text-gray"></i></div>
                            </div>
                        </a><a class="dropdown-item" href="<?=PUBLIC_URL?>admin/logout">Sign Out</a></div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas"><span class="mdi mdi-menu"></span></button>
        </div>
    </nav><!-- partial-->
    <div class="container-fluid page-body-wrapper"><!-- partial:partials/_sidebar.html-->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <div class="nav-link">
                        <div class="user-wrapper">
                            <div class="profile-image"><img src="<?=PUBLIC_URL?>admin/images/faces/face1.jpg" alt="profile image">
                            </div>
                            <div class="text-wrapper"><p class="profile-name">admin</p>
                                <div>
                                    <small class="designation text-muted">admin</small>
                                    <span class="status-indicator online"></span></div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item active"><a class="nav-link" data-toggle="collapse" href="#categories_nav"
                                               aria-expanded="false" aria-controls="categories_nav"><i
                            class="menu-icon mdi mdi-content-copy"></i><span class="menu-title">Categories</span><i
                            class="menu-arrow"></i></a>
                    <div class="collapse show" id="categories_nav">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link active" href="<?=Application::getUrl("admin", "categories")?>">All</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item active"><a class="nav-link" data-toggle="collapse" href="#authors_nav"
                                               aria-expanded="false" aria-controls="authors_nav"><i
                            class="menu-icon mdi mdi-content-copy"></i><span class="menu-title">Authors</span><i
                            class="menu-arrow"></i></a>
                    <div class="collapse show" id="authors_nav">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link active" href="<?=Application::getUrl("admin", "authors")?>">All</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item active"><a class="nav-link" data-toggle="collapse" href="#publishers_nav"
                                               aria-expanded="false" aria-controls="publishers_nav"><i
                            class="menu-icon mdi mdi-content-copy"></i><span class="menu-title">Publishers</span><i
                            class="menu-arrow"></i></a>
                    <div class="collapse show" id="publishers_nav">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link active" href="<?=Application::getUrl("admin", "publishers")?>">All</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item active"><a class="nav-link" data-toggle="collapse" href="#books_nav"
                                               aria-expanded="false" aria-controls="books_nav"><i
                            class="menu-icon mdi mdi-content-copy"></i><span class="menu-title">Books</span><i
                            class="menu-arrow"></i></a>
                    <div class="collapse show" id="books_nav">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link active" href="<?=Application::getUrl("admin", "books")?>">All</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav><!-- partial-->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <?php /** @var string $content */
                    include_once $content?>
                </div>
            </div><!-- content-wrapper ends--><!-- partial:partials/_footer.html-->
            <footer class="footer">
                <div class="container-fluid clearfix"><span
                        class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018. All rights reserved.</span><span
                        class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with<i
                            class="mdi mdi-heart text-danger"></i></span></div>
            </footer>
            <script src="<?=PUBLIC_URL?>admin/vendors/js/vendor.bundle.base.js"></script>
            <script src="<?=PUBLIC_URL?>admin/vendors/js/vendor.bundle.addons.js"></script>
            <script src="<?=PUBLIC_URL?>admin/js/off-canvas.js"></script>
            <script src="<?=PUBLIC_URL?>admin/js/misc.js"></script>
            <script src="<?=PUBLIC_URL?>admin/js/dashboard.js"></script>
        </div>
    </div>
</div>
</body>


</html>