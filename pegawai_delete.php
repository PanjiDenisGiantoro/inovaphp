<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])){
	$mySql = "DELETE FROM pegawai WHERE kd_pegawai='".$_GET['Kode']."'";
	$myQry = mysqli_query($koneksidb,$mySql);
	if($myQry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?page=Dokter-Data'>";
	}
}
else {
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>