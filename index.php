<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";
include_once "library/inc.tanggal.php";

// Baca Jam pada Komputer
date_default_timezone_set("Asia/Jakarta");
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Starter page | Fonik - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="./dist/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons Css -->
    <link href="./dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="./dist/assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">

<!-- Loader -->
<div id="preloader"><div id="status"><div class="spinner"></div></div></div>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="20">
                                </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                        <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="20">
                                </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

                <div class="d-none d-sm-block ml-2">
                    <h4 class="page-title font-size-18">Starter</h4>
                </div>

            </div>

            <!-- Search input -->
            <div class="search-wrap" id="search-wrap">
                <div class="search-bar">
                    <input class="search-input form-control" placeholder="Search" />
                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                        <i class="mdi mdi-close-circle"></i>
                    </a>
                </div>
            </div>

            <div class="d-flex">

             



                <div class="dropdown d-none d-lg-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>







            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->


    <!-- Left Sidebar End -->
    <?php include "menu.php";?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <?php include "buka_file.php";?>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        © 2018 - <script>document.write(new Date().getFullYear())</script> Fonik<span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand.</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->

<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="./dist/assets/libs/jquery/jquery.min.js"></script>
<script src="./dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./dist/assets/libs/metismenu/metisMenu.min.js"></script>

<script src="./bower_components1/simplebar/simplebar.min.js"></script>
<script src="./bower_components1/node-waves/waves.min.js"></script>
<script src="./dist/assets/js/app.js"></script>
<script src="./bower_components1/raphael/raphael-min.js"></script>
<script src="./bower_components1/morrisjs/morris.min.js"></script>
<script src="./js/morris-data.js"></script>

<!-- Custom Theme JavaScript -->
<script src="./dist/js/sb-admin-2.js"></script>

</body>

</html>