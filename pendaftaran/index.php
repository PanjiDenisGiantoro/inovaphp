<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

date_default_timezone_set("Asia/Jakarta");
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>PENDAFTARAN PASIEN - KLINIK </title>
        <link href="../styles/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css" />
        <script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script>
        <link href="../dist/assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- Icons Css -->
        <link href="../dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../dist/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>
    <body data-sidebar="dark">
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


            </div>

            <!-- Search input -->


            <div class="d-flex">







            </div>
        </div>
    </header>
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">
                <ul class="nav" id="side-menu">

                    <li><a href="?page=Pendaftaran-Baru" target="_self">Pendaftaran Baru</a></li>

                    <li><a href="?page=Pendaftaran-Tampil" target="_self">Tampil Pendaftaran </a></li>
                    <li><a href="../" target="_self">HOME</a> </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <?php
                if(isset($_GET['page'])) {
                    switch($_GET['page']){
                        case 'Pendaftaran-Baru' :
                            if(!file_exists ("pendaftaran_baru.php")) die ("Empty Main Page!");
                            include "pendaftaran_baru.php";	break;
                        case 'Pendaftaran-Ubah' :
                            if(!file_exists ("pendaftaran_ubah.php")) die ("Empty Main Page!");
                            include "pendaftaran_ubah.php";	break;
                        case 'Pendaftaran-Hapus' :
                            if(!file_exists ("pendaftaran_hapus.php")) die ("Empty Main Page!");
                            include "pendaftaran_hapus.php";	break;
                        case 'Pendaftaran-Tampil' :
                            if(!file_exists ("pendaftaran_data.php")) die ("Empty Main Page!");
                            include "pendaftaran_data.php";	break;
                        case 'Pencarian-Pasien' :
                            if(!file_exists ("pencarian_pasien.php")) die ("Empty Main Page!");
                            include "pencarian_pasien.php";	break;
                    }
                }
                else {
                    include "pendaftaran_baru.php";
                }
                ?>
            </div>
            <!-- container-fluid -->
        </div>
    </div>
        <!-- End Page-content -->




</body>
</html>
