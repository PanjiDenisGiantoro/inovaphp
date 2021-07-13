<?php
include_once "../library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	
	// Hapus data sesuai Kode yang didapat di URL
	$mySql = "DELETE FROM rawat WHERE no_rawat='$Kode'";
	$myQry = mysqli_query($koneksidb,$mySql);
	if($myQry){
		// Hapus data pada tabel anak (rawat_tindakan)
		$mySql = "DELETE FROM rawat_tindakan WHERE no_rawat='$Kode'";
		mysqli_query($koneksidb,$mySql);

		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?page=Rawat-Tampil'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>