<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pegawai";
$pageQry = mysqli_query($koneksidb,$pageSql);
$jml	 = mysqli_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>


<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Data Pegawai</h1>
</div>
<!-- /.col-lg-12 -->
</div>


<table  class="table table-striped table-bordered table-hover" id="dataTables-example"  width="100%"cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2"><a href="?page=Pegawai-Add" target="_self"class="btn btn-primary">Tambah Pegawai</a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
<div class="dataTable-wrapper">
<div class="table-responsive">
<table  class="table table-striped table-bordered table-hover" id="dataTables-example"  width="100%"cellspacing="1" cellpadding="3">
      <tr>
        <th width="24" align="center"><strong>No</strong></th>
        <th width="189"><strong>Nama Pegawai </strong></th>
        <th width="110"><strong>Email</strong></th>
        <th width="115"><strong>No. Telepon </strong></th>
        <th width="215"><strong>Alamat </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
	$mySql = "SELECT * FROM pegawai ORDER BY kd_pegawai ASC LIMIT $hal, $row";
	$myQry = mysqli_query($koneksidb,$mySql);
	$nomor = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_pegawai'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['nm_pegawai']; ?></td>
        <td><?php echo $myData['email']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td><?php echo $myData['alamat']; ?></td>
        <td width="45" align="center"><a href="?page=Pegawai-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
        <td width="50" align="center"><a href="?page=Pegawai-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA Pegawai INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>
</div></div>
    </td>
  </tr>
  <tr class="selKecil">
    <td width="306"><strong>Jumlah Data :</strong> <?php echo $jml; ?></td>
    <td width="483" align="right"><strong>Halaman ke :</strong>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Pegawai-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
