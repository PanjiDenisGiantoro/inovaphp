<?php

if(isset($_POST['btnSimpan'])){
	$pesanError = array();
	if (trim($_POST['txtNama'])=="") {
		$pesanError[] = "Data <b>Nama Tindakan</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtHarga'])=="") {
		$pesanError[] = "Data <b>Harga (Rp.)</b> tidak boleh kosong !";		
	}
	
	$txtNama	= $_POST['txtNama'];
	$txtHarga	= $_POST['txtHarga'];
    $koneksidb	= mysqli_connect('localhost','root','','inovaklinik');

	$cekSql="SELECT * FROM tindakan WHERE nm_tindakan='$txtNama'";
	$cekQry=mysqli_query($koneksidb,$cekSql);
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, Tindakan <b> $txtNama </b> sudah ada, ganti dengan yang lain";
	}

	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
//

        $query = "SELECT max(kd_tindakan) as maxKode FROM tindakan";
        $hasil = mysqli_query($koneksidb,$query);
        $data = mysqli_fetch_array($hasil);
        $kodetindakan = $data['maxKode'];
        $noUrut = (int) substr($kodetindakan, 3, 3);
        $noUrut++;
        $char = "T";
        $kodetindakan1 = $char . sprintf("%03s", $noUrut);
		$mySql	= "INSERT INTO tindakan (kd_tindakan, nm_tindakan, harga) VALUES ('$kodetindakan1','$txtNama','$txtHarga')";
		$myQry	= mysqli_query($koneksidb,$mySql);
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Tindakan-Data'>";
		}
		var_dump("$mySql");
	}
}

$query = "SELECT max(kd_tindakan) as maxKode FROM tindakan";
$hasil = mysqli_query($koneksidb,$query);
$data = mysqli_fetch_array($hasil);
$kodetindakan = $data['maxKode'];
$noUrut = (int) substr($kodetindakan, 3, 3);
$noUrut++;
$char = "T";
$kodetindakan1 = $char . sprintf("%03s", $noUrut);
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataHarga	= isset($_POST['txtHarga']) ? $_POST['txtHarga'] : '';
?>
<div class="col-8">
    <div class="card">
        <div class="card-body">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="100%" class="table-list" border="0" cellpadding="4" cellspacing="1">
    <br>
	<tr>
        <th colspan="3" scope="col" ><b>TAMBAH TINDAKAN</b> </th>
    </tr>
    <tr>
      <td width="181"><strong>Kode</strong></td>
      <td width="3">:</td>
      <td width="1019"><input name="textfield"class="form-control" value="<?php echo $kodetindakan1; ?>"  style="width: 10%" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Nama Tindakan </strong></td>
      <td>:</td>
      <td><input name="txtNama" class="form-control"value="<?php echo $dataNama; ?>" style="width: 70%" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Harga (Rp.) </strong></td>
      <td>:</td>
      <td><input name="txtHarga"class="form-control" value="<?php echo $dataHarga; ?>"  style="width: 20%" maxlength="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" class="btn btn-primary" value=" SIMPAN "></td>
    </tr>
  </table>
</form>
        </div>
    </div>
</div>
