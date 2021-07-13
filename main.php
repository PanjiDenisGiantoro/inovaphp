<?php
if(isset($_SESSION['SES_ADMIN'])) {
?>


<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Home</h1>
</div>

<h4>Admin</h4></b><br/>

	<?php
}
else if(isset($_SESSION['SES_KLINIK'])) {

?>


<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Home</h1>
</div>

<h4>Data Klinik</h4></b><br/>


            <!-- /.row -->

            <!-- /.row -->

	<?php

}
else if(isset($_SESSION['SES_APOTEK'])) {
?>
<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Home</h1>
</div>

<h4>Pengolahan Data Obat</h4></b><br/>
	<?php
}
else {
	?>
	<br><br><br>
	<img src="./images/logoheader.jpg" width="650px" style="setImageOpacity(3.3);">
	<br><br>
	<h2>E Klinik </h2>
	<b>Alamat :<b/>
	<p>JAWA BARAT<p/>
	<b>Anda belum login, silahkan <a href='?page=Login' alt='Login'>LOGIN </a>Untuk dapat mengakses Sistem ini </b>
<?php
}
?>