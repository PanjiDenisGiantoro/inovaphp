<?php
include_once "../library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	
	// Hapus data sesuai Kode yang didapat di URL
	$mySql = "DELETE FROM resep WHERE no_penjualan='$Kode'";
	$myQry = mysqli_query($koneksidb,$mySql);
	if($myQry){
	
		// Baca data dalam tabel anak (penjualan_item)
		$bacaSql = "SELECT * FROM resep_item WHERE no_penjualan='$Kode'";
		$bacaQry = mysqli_query($koneksidb,$bacaSql);
		while($bacaData = mysqli_fetch_array($bacaQry)) {
			$KodeObat	= $bacaData['kd_obat'];
			$jumlah		= $bacaData['jumlah'];
			
			// Skrip Kembalikan Jumlah Stok
			$stokSql = "UPDATE obat SET stok = stok + $jumlah WHERE kd_obat='$KodeObat'";
			mysqli_query($koneksidb,$stokSql);
		}
		
		// Hapus data pada tabel anak (penjualan_item)
		$mySql = "DELETE FROM resep_item WHERE no_penjualan='$Kode'";
		mysqli_query($koneksidb,$mySql);

		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?page=Resep-Tampil'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>