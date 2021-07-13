<?php
include_once "../library/inc.seslogin.php";

// Membaca variabel form
$KeyWord	= isset($_GET['KeyWord']) ? $_GET['KeyWord'] : '';
$dataCari	= isset($_POST['txtCari']) ? $_POST['txtCari'] : $KeyWord;

// Jika tombol Cari diklik
if(isset($_POST['btnCari'])){
	if($_POST) {
		$filterSql = "WHERE nm_tindakan LIKE '%$dataCari%'";
	}
}
else {
	if($KeyWord){
		$filterSql = "WHERE nm_tindakan LIKE '%$dataCari%'";
	}
	else {
		$filterSql = "";
	}
} 

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM tindakan $filterSql";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>Cari Data Tindakan</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <strong>Cari Tindakan Pasien :</strong>
  <input name="txtCari" type="text" value="<?php echo $dataCari; ?>" size="40" maxlength="100" />
  <input name="btnCari" type="submit" value="Cari" />
</form>
<table  class="table-list" width="700" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <th width="20" bgcolor="#CCCCCC">No</th>
    <th width="80" bgcolor="#CCCCCC"><strong>Kode Tindakan </strong></th>
    <th width="160" bgcolor="#CCCCCC"><strong>Nama Tindakan </strong></th>
    <th width="60" bgcolor="#CCCCCC"><strong>Harga</strong></th>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
<?php
$mySql = "SELECT * FROM tindakan $filterSql ORDER BY kd_tindakan ASC LIMIT $hal, $row";
$myQry = mysqli_query($koneksidb,$mySql);
$nomor = 0; 
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_tindakan']; ?></td>
    <td><?php echo $myData['nm_tindakan']; ?></td>
    <td><?php echo $myData['harga']; ?></td>
    
    <td><a href="?../&NomorTindakan=<?php echo $myData['nm_tindakan']; ?>" target="_self" alt="Rawat">Tindakan</a></td>
  </tr>
<?php } ?>  
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong> </td>
    <td colspan="4" align="right"><strong>Halaman ke : </strong>
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Pencarian-Tindakan&hal=$list[$h]&KeyWord=$dataCari'>$h</a> ";
	}
	?></td>
  </tr>
</table>
