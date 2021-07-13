<?php
include_once "../library/inc.seslogin.php";

// Membaca variabel form
$KeyWord	= isset($_GET['KeyWord']) ? $_GET['KeyWord'] : '';
$dataCari	= isset($_POST['txtCari']) ? $_POST['txtCari'] : $KeyWord;

// Jika tombol Cari diklik
if(isset($_POST['btnCari'])){
	if($_POST) {
		$filterSql = "WHERE nm_pasien LIKE '%$dataCari%'";
	}
}
else {
	if($KeyWord){
		$filterSql = "WHERE nm_pasien LIKE '%$dataCari%'";
	}
	else {
		$filterSql = "";
	}
} 

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM rawat $filterSql";
$pageQry = mysqli_query($koneksidb,$pageSql);
$jml	 = mysqli_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>Data Penerimaan Resep Obat Pasien</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <strong>Cari Pasien :</strong>
  <input name="txtCari" type="text" value="<?php echo $dataCari; ?>" size="40" maxlength="100" />
  <input name="btnCari" type="submit" value="Cari" />
</form>
<table  class="table-list" width="700" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <th width="20" bgcolor="#CCCCCC">No</th>
    <th width="90" bgcolor="#CCCCCC"><strong>No.Periksa </strong></th>
    <th width="160" bgcolor="#CCCCCC"><strong>Nama Pasien </strong></th>
    <th width="100" bgcolor="#CCCCCC"><strong>Diagnosa</strong></th>
    <th width="77" bgcolor="#CCCCCC"><strong>Pembayaran </strong></th>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
<?php
$mySql = "SELECT * FROM rawat $filterSql ORDER BY no_rawat ASC LIMIT $hal, $row";
$myQry = mysqli_query($koneksidb,$mySql);
$nomor = 0; 
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['no_rawat']; ?></td>
    <td><?php echo $myData['nm_pasien']; ?></td>
    <td><?php echo $myData['hasil_diagnosa']; ?></td>
    <td><?php echo $myData['uang_bayar']; ?></td>
    
    <td><a href="?page=Resep-Baru&nomorpasien=<?php echo $myData['no_rawat']; ?>" target="_self" alt="Rawat">Proses</a></td>
  </tr>
<?php } ?>  
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong> </td>
    <td colspan="4" align="right"><strong>Halaman ke : </strong>
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Pencarian-Pasien&hal=$list[$h]&KeyWord=$dataCari'>$h</a> ";
	}
	?></td>
  </tr>
</table>
