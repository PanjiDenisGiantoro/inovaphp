<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])){
	// Hapus data sesuai Kode yang didapat di URL
	$mySql = "DELETE FROM petugas WHERE kd_petugas='".$_GET['Kode']."' AND username !='admin'";
	$myQry = mysqli_query($koneksidb,$mySql);
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?page=Petugas-Data'>";
	}
}
else {
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>