<?php
if(isset($_SESSION['SES_ADMIN'])){
?>
   <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">
<ul class="nav" id="side-menu">
                        

    <li>
        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Data<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href='?page=Tindakan-Data' title='Tindakan'>Data Tindakan</a></li>
            <li><a href='?page=Petugas-Data' title='User'>Data User</a></li>
            <li><a href='?page=Pegawai-Data' title='Pegawai' target="_self">Data Pegawai</a></li>
            <li><a href='?page=Obat-Data' title='Obat'>Data Obat</a></li>
            <li><a href='?page=Pasien-Data' title='Pasien'>Data Pasien</a> </li>
            <li><a href='?page=Wilayah-Data' title='Wilayah Provinsi'>Data Wilayah provinsi</a> </li>
            <li><a href='?page=Kota-Data' title='Wilayah kota'>Data Wilayah kota</a> </li>
            <li><a href='?page=Grafik-Data' title='Grafik'>Grafik</a> </li>

        </ul>
    </li>
	<li><a href='pendaftaran/' title='Pendaftaran Pasien' target='_blank'> Pendaftaran Pasien</a> </li>

	<li><a href='rawat-pasien/' title='Rawat Pasien' target='_blank'> Rawat Jalan Pasien</a> </li>
	<li><a href='resep/' title='Rawat Pasien' target='_blank'>Pengambilan Resep</a> </li>
	<li><a href='?page=Logout' title='Logout (Exit)'><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
</ul>

</div></div></div>
<?php
}
elseif(isset($_SESSION['SES_KLINIK'])){
# JIKA YANG LOGIN LEVEL PETUGAS JAGA KLINIK, menu di bawah yang dijalankan
?>
 <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">


                <ul class="nav" id="side-menu">
                    <li><a href='pendaftaran/' title='Pendaftaran Pasien' target='_blank'>Pendaftaran Pasien</a> </li>
                    <li><a href='rawat-pasien/' title='Rawat Pasien' target='_blank'>Pemeriksaan Pasien</a> </li>
                    <li><a href='?page=Logout' title='Logout (Exit)'>Logout</a></li>
                </ul>
</div></div></div>
<?php
}
elseif(isset($_SESSION['SES_APOTEK'])){
# JIKA YANG LOGIN LEVEL KASIR APOTEK, menu di bawah yang dijalankan
?>
<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav navbar-collapse">

<ul class="nav" id="side-menu">

</ul>

</div></div>

    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">


                <ul class="nav" id="side-menu">
                    <li><a href='?page' title='Halaman Utama'>Home</a></li>
                    <li><a href='resep/index.php' title='Penjualan Apotek' target='_blank'>Penerimaan Resep Obat</a> </li>
                    <li><a href='?page=Logout' title='Logout (Exit)'>Logout</a></li>
                </ul>
            </div></div></div>
<?php
}
else {
# JIKA BELUM LOGIN (BELUM ADA SESION LEVEL YG DIBACA)
?>
<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav navbar-collapse">

<ul class="nav" id="side-menu">
	<li></li>
</ul>

</div></div>
<?php
}
?>