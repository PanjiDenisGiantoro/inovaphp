<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])){
	$pesanError = array();
	if (trim($_POST['txtNama'])=="") {
		$pesanError[] = "Data <b>Nama pegawai</b> tidak boleh kosong !";
	}
	if (trim($_POST['cmbKelamin'])=="KOSONG") {
		$pesanError[] = "Data <b>Jenia Kelamin</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTempatLahir'])=="") {
		$pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtAlamat'])=="") {
		$pesanError[] = "Data <b>Alamat Tinggal</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTelepon'])=="") {
		$pesanError[] = "Data <b>No Telepon</b> tidak boleh kosong !";		
	}

	if (trim($_POST['txtSpesialis'])=="") {
		$pesanError[] = "Data <b>Email</b> tidak boleh kosong !";
	}

	# Baca Variabel Form
	$txtNama	= $_POST['txtNama'];
	$cmbKelamin	= $_POST['cmbKelamin'];
	$txtAlamat	= $_POST['txtAlamat'];
	$txtTelepon	= $_POST['txtTelepon'];
	$txtSpesialis	= $_POST['txtSpesialis'];

	$txtTempatLahir	= $_POST['txtTempatLahir'];
	
	$cmbTglLahir	= $_POST['cmbTglLahir'];
	$cmbBlnLahir	= $_POST['cmbBlnLahir'];
	$cmbThnLahir	= $_POST['cmbThnLahir'];
	$tanggalLahir	= "$cmbThnLahir-$cmbBlnLahir-$cmbTglLahir";
	
	$cekSql="SELECT * FROM pegawai WHERE nm_pegawai='$txtNama' AND NOT(nm_pegawai='".$_POST['txtNamaLama']."')";
	$cekQry=mysqli_query($koneksidb,$cekSql);
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, pegawai <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
		$mySql	= "UPDATE pegawai SET nm_pegawai = '$txtNama',
					jns_kelamin = '$cmbKelamin',
					tempat_lahir = '$txtTempatLahir',
					tanggal_lahir = '$tanggalLahir',
					alamat = '$txtAlamat',
					no_telepon = '$txtTelepon',
					email = '$txtSpesialis',
				  WHERE kd_pegawai ='".$_POST['txtKode']."'";
		$myQry	= mysqli_query($koneksidb,$mySql);
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pegawai-Data'>";
		}
		exit;
	}	
}

$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql	= "SELECT * FROM pegawai WHERE kd_pegawai='$Kode'";
$myQry	= mysqli_query($koneksidb,$mySql);
$myData = mysqli_fetch_array($myQry);

	$dataKode	= $myData['kd_pegawai'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_pegawai'];
	$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : $myData['jns_kelamin'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataSpesialis	= isset($_POST['txtSpesialis']) ? $_POST['txtSpesialis'] : $myData['email'];

	$dataTempatLahir= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : $myData['tempat_lahir'];
	$dataTglLahir	= isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : $myData['tanggal_lahir'];
?>
<div class="col-8">
    <div class="card">
        <div class="card-body">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">UBAH DATA PEGAWAI</th>
    </tr>
    <tr>
      <td width="16%"><strong>Kode</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="83%"><input name="textfield"class="form-control" value="<?php echo $dataKode; ?>" style="width: 10%"  maxlength="10" readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Nama pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama"class="form-control" value="<?php echo $dataNama; ?>" style="width: 80%"  maxlength="100" />
      <input name="txtNamaLama" type="hidden" value="<?php echo $myData['nm_pegawai']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Jenis Kelamin </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbKelamin"class="form-control">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Laki-laki", "Perempuan");
          foreach ($pilihan as $nilai) {
            if ($dataKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Tempat, Tgl. Lahir </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTempatLahir"class="form-control" type="text"  value="<?php echo $dataTempatLahir; ?>" style="width: 40%"  maxlength="100" />
        , <?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><strong>Alamat Tinggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamat"class="form-control" value="<?php echo $dataAlamat; ?>" style="width: 80%"  maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>No Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTelepon"class="form-control" value="<?php echo $dataTelepon; ?>"style="width: 20%"  maxlength="20" /></td>
    </tr>

    <tr>
      <td><strong>Email</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtSpesialis"class="form-control" value="<?php echo $dataSpesialis; ?>" style="width: 60%"  maxlength="60" /></td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" value=" SIMPAN "></td>
    </tr>
  </table>
</form>
        </div>
    </div>
</div>
