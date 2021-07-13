<?php
include_once "library/inc.seslogin.php";

# Tombol Simpan diklik
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
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";		
	}



	
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtTelepon		= $_POST['txtTelepon'];
	$txtSpesialis	= $_POST['txtSpesialis'];

	$txtTempatLahir	= $_POST['txtTempatLahir'];
	
	$cmbTglLahir	= $_POST['cmbTglLahir'];
	$cmbBlnLahir	= $_POST['cmbBlnLahir'];
	$cmbThnLahir	= $_POST['cmbThnLahir'];
	$tanggalLahir	= "$cmbThnLahir-$cmbBlnLahir-$cmbTglLahir";

	
	$cekSql="SELECT * FROM pegawai WHERE nm_pegawai='$txtNama'";
	$cekQry=mysqli_query($koneksidb,$cekSql);
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "Maaf, pegawai <b> $txtNama </b> sudah ada, ganti dengan yang lain";
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
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
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database	
        $query = "SELECT max(kd_pegawai) as maxKode FROM pegawai";
        $hasil = mysqli_query($koneksidb,$query);
        $data = mysqli_fetch_array($hasil);
        $kodepegawai = $data['maxKode'];
        $noUrut = (int) substr($kodepegawai, 3, 3);
        $noUrut++;
        $char = "T";
        $kodepegawai = $char . sprintf("%03s", $noUrut);
		$mySql	= "INSERT INTO pegawai (kd_pegawai, nm_pegawai, jns_kelamin, tempat_lahir, tanggal_lahir,  alamat, no_telepon, email) 
					VALUES ('$kodepegawai', '$txtNama', '$cmbKelamin',
							'$txtTempatLahir', '$tanggalLahir', '$txtAlamat',
							'$txtTelepon', '$txtSpesialis')";
		$myQry	= mysqli_query($koneksidb,$mySql);
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pegawai-Add'>";
		}
		var_dump("$mySql");
	}	
}
$query = "SELECT max(kd_pegawai) as maxKode FROM pegawai";
$hasil = mysqli_query($koneksidb,$query);
$data = mysqli_fetch_array($hasil);
$kodepegawai = $data['maxKode'];
$noUrut = (int) substr($kodepegawai, 3, 3);
$noUrut++;
$char = "T";
$kodepegawai = $char . sprintf("%03s", $noUrut);
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
$dataSIP	= isset($_POST['txtSIP']) ? $_POST['txtSIP'] : '';
$dataSpesialis	= isset($_POST['txtSpesialis']) ? $_POST['txtSpesialis'] : '';
$dataBagiHasil	= isset($_POST['txtBagiHasil']) ? $_POST['txtBagiHasil'] : '';

$dataTempatLahir= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : '';

$dataThn		= isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : date('Y');
$dataBln		= isset($_POST['cmbBlnLahir']) ? $_POST['cmbBlnLahir'] : date('m');
$dataTgl		= isset($_POST['cmbTglLahir']) ? $_POST['cmbTglLahir'] : date('d');
$dataTglLahir 	= $dataThn."-".$dataBln."-".$dataTgl;

?>

<div class="col-8">
    <div class="card">
        <div class="card-body">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
   	<tr>
     <th colspan="3"  scope="col">TAMBAH DATA PEGAWAI </th>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <br>
	</tr>
	
    <tr>
	  <td width="16%"><strong>Kode</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="83%"><input name="textfield" value="<?php echo $kodepegawai; ?>" class="form-control"style="width: 10%"  maxlength="10" readonly="readonly"/></td>
    <tr>
	
    <tr>
      <td><strong>Nama pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" value="<?php echo $dataNama; ?>" class="form-control"style="width: 80%" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Jenis Kelamin </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbKelamin"class="form-control"style="width:80%">
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
      <td><input name="txtTempatLahir" type="text"  value="<?php echo $dataTempatLahir; ?>" class="form-control"style="width: 40%"size="40" maxlength="100" />
        , 
      <?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><strong>Alamat Tinggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" class="form-control"style="width: 80%"maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" class="form-control"style="width: 20%" maxlength="20" /></td>
    </tr>

    <tr>
      <td><strong>email</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtSpesialis" value="<?php echo $dataSpesialis; ?>" class="form-control"style="width: 60%"maxlength="60" /></td>
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