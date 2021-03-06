<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])){
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($_POST['txtNama'])=="") {
		$pesanError[] = "Data <b>Nama Pasien</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtNoIdentitas'])=="") {
		$pesanError[] = "Data <b>No. Identitas</b> tidak boleh kosong !";
	}
	if (trim($_POST['cmbKelamin'])=="KOSONG") {
		$pesanError[] = "Data <b>Jenia Kelamin</b> belum dipilih !";
	}	
	if (trim($_POST['cmbGDarah'])=="KOSONG") {
		$pesanError[] = "Data <b>Golongan Darah</b> belum dipilih !";
	}	
	if (trim($_POST['cmbAgama'])=="KOSONG") {
		$pesanError[] = "Data <b>Agama</b> belum dipilih !";
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
	if (trim($_POST['cmbSttsNikah'])=="KOSONG") {
		$pesanError[] = "Data <b>Status Nikah</b> belum dipilih !";
	}
	if (trim($_POST['cmbPekerjaan'])=="KOSONG") {
		$pesanError[] = "Data <b>Pekerjaan</b> belum dipilih !";
	}
	if (trim($_POST['cmbSttsKeluarga'])=="KOSONG") {
		$pesanError[] = "Data <b>Status Keluarga</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtKlgNama'])=="") {
		$pesanError[] = "Data <b>Nama Keluarga</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtKlgTelepon'])=="") {
		$pesanError[] = "Data <b>No. Telepon </b> tidak boleh kosong !";
	}
    if (trim($_POST['provinsi'])=="") {
        $pesanError[] = "Data <b> provunsi </b> tidak boleh kosong !";
    }
    if (trim($_POST['kota'])=="") {
        $pesanError[] = "Data <b>Kota </b> tidak boleh kosong !";
    }
	
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$txtNoIdentitas	= $_POST['txtNoIdentitas'];
	$cmbKelamin		= $_POST['cmbKelamin'];
	$cmbGDarah		= $_POST['cmbGDarah'];
	$cmbAgama		= $_POST['cmbAgama'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtTelepon		= $_POST['txtTelepon'];
	$cmbSttsNikah	= $_POST['cmbSttsNikah'];
	$cmbPekerjaan	= $_POST['cmbPekerjaan'];
	$cmbSttsKeluarga= $_POST['cmbSttsKeluarga'];
	$txtKlgNama		= $_POST['txtKlgNama'];
	$txtKlgTelepon	= $_POST['txtKlgTelepon'];
	$txtTempatLahir	= $_POST['txtTempatLahir'];
	$provinsi	= $_POST['provinsi'];
	$kota	= $_POST['kota'];

	// Membaca form tanggal lahir (comboBox : tanggal, bulan dan tahun lahir)
	$cmbTglLahir	= $_POST['cmbTglLahir'];
	$cmbBlnLahir	= $_POST['cmbBlnLahir'];
	$cmbThnLahir	= $_POST['cmbThnLahir'];
	$tanggalLahir	= "$cmbThnLahir-$cmbBlnLahir-$cmbTglLahir";

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
		$tanggal	= date('Y-m-d');
		$petugas	= $_SESSION['SES_LOGIN'];
        $query = "SELECT max(nomor_rm) as maxKode FROM pasien";
        $hasil = mysqli_query($koneksidb,$query);
        $data = mysqli_fetch_array($hasil);
        $kodepetugas = $data['maxKode'];
        $noUrut = (int) substr($kodepetugas, 3, 3);
        $noUrut++;
        $char = "RM";
        $kodeBaru = $char . sprintf("%03s", $noUrut);
		$mySql	= "INSERT INTO pasien (nomor_rm, nm_pasien, no_identitas, jns_kelamin, 
						gol_darah, agama, tempat_lahir, tanggal_lahir, 
						no_telepon, alamat, stts_nikah, pekerjaan, 
						keluarga_status, keluarga_nama, keluarga_telepon, tgl_rekam, 
						kd_petugas,provinsi,kota) 
					VALUES ('$kodeBaru', '$txtNama', '$txtNoIdentitas', '$cmbKelamin', 
							'$cmbGDarah', '$cmbAgama', '$txtTempatLahir', '$tanggalLahir', 
							'$txtTelepon', '$txtAlamat', '$cmbSttsNikah', '$cmbPekerjaan', 
							'$cmbSttsKeluarga', '$txtKlgNama', '$txtKlgTelepon', '$tanggal', '$petugas','$provinsi','$kota')";

		$myQry	= mysqli_query($koneksidb,$mySql);
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pasien-Add'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# VARIABEL DATA UNTUK DIBACA FORM
$query = "SELECT max(nomor_rm) as maxKode FROM pasien";
$hasil = mysqli_query($koneksidb,$query);
$data = mysqli_fetch_array($hasil);
$kodepetugas = $data['maxKode'];
$noUrut = (int) substr($kodepetugas, 3, 3);
$noUrut++;
$char = "RM";
$kodeBaru = $char . sprintf("%03s", $noUrut);
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataNoIdentitas= isset($_POST['txtNoIdentitas']) ? $_POST['txtNoIdentitas'] : '';
$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataGDarah	= isset($_POST['cmbGDarah']) ? $_POST['cmbGDarah'] : '';
$dataAgama	= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
$dataSttsNikah	= isset($_POST['cmbSttsNikah']) ? $_POST['cmbSttsNikah'] : '';
$dataPekerjaan	= isset($_POST['cmbPekerjaan']) ? $_POST['cmbPekerjaan'] : '';
$dataSttsKeluarga= isset($_POST['cmbSttsKeluarga']) ? $_POST['cmbSttsKeluarga'] : '';
$dataKlgNama	= isset($_POST['txtKlgNama']) ? $_POST['txtKlgNama'] : '';
$dataKlgTelepon	= isset($_POST['txtKlgTelepon']) ? $_POST['txtKlgTelepon'] : '';
$provinsi	= isset($_POST['provinsi']) ? $_POST['provinsi'] : '';
$kota	= isset($_POST['kota']) ? $_POST['kota'] : '';

// Tempat, Tgl Lahir
$dataTempatLahir= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : '';
$dataThn		= isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : date('Y');
$dataBln		= isset($_POST['cmbBlnLahir']) ? $_POST['cmbBlnLahir'] : date('m');
$dataTgl		= isset($_POST['cmbTglLahir']) ? $_POST['cmbTglLahir'] : date('d');
$dataTglLahir 	= $dataThn."-".$dataBln."-".$dataTgl;
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" target="_self">
  <table  class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
    <br>
	<tr>
      <th colspan="3" bgcolor="#CCCCCC"><strong>TAMBAH DATA PASIEN </strong></th>
    </tr>
    <tr>
      <td width="15%"><strong>Kode</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="84%"><input name="textfield" value="<?php echo $kodeBaru; ?>" size="10" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Nama Pasien </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>No. Identitas (KTP/SIM) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoIdentitas" value="<?php echo $dataNoIdentitas; ?>" size="40" maxlength="40" /></td>
    </tr>
    <tr>
      <td><b>Jenis Kelamin </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbKelamin">
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
      <td><b>Gol. Darah </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbGDarah">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("A", "B", "AB", "O");
          foreach ($pilihan as $nilai) {
            if ($dataGDarah == $nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbAgama">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Islam", "Kristen", "Katolik", "Buda", "Hindu");
          foreach ($pilihan as $nilai) {
            if ($dataAgama ==$nilai) {
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
      <td><input name="txtTempatLahir" type="text"  value="<?php echo $dataTempatLahir; ?>" size="40" maxlength="100" />
        , <?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><strong>Alamat Tinggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" /></td>
    </tr>
      <tr>
          <td><strong>Provinsi </strong></td>
          <td><strong>:</strong></td>
          <td><select name="provinsi" id="provinsi">
                  <option value=""></option>
                  <?php
                  $bacaSql = "SELECT * FROM provinsi ORDER BY namaprovinsi";
                  $bacaQry = mysqli_query($koneksidb,$bacaSql);
                  while ($bacaData = mysqli_fetch_array($bacaQry)) {


                      echo "<option value='$bacaData[id]'> $bacaData[namaprovinsi]</option>";
                  }
                  ?>
              </select></td>

      </tr>
      <tr>
          <td><strong>Kota </strong></td>
          <td><strong>:</strong></td>
          <td><select name="kota" id="kota">

              </select>
          </td>
      </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Status Nikah </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbSttsNikah">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Menikah", "Belum Nikah");
          foreach ($pilihan as $nilai) {
            if ($dataSttsNikah ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Pekerjaan</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbPekerjaan">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Pegawai Negri Sipil(PNS)", 
		  					"Karyawan",
							"Wiraswasta",
							"Petani");
          foreach ($pilihan as $nilai) {
            if ($dataPekerjaan ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong> KELUARGA</strong> </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><b>Status Keluarga </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbSttsKeluarga">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Ayah", "Ibu", "Suami", "Istri", "Saudara");
          foreach ($pilihan as $nilai) {
            if ($dataSttsKeluarga ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Nama Keluarga </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKlgNama" value="<?php echo $dataKlgNama; ?>" size="80" maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKlgTelepon" value="<?php echo $dataKlgTelepon; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" value=" SIMPAN "></td>
    </tr>
  </table>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.3.2/select2.min.js"></script>
<script>
    $(document).on('change','#provinsi', function(){
        var provinsi = $(this).val();
        if(provinsi){
            $.ajax({
                type:'POST',
                url:'datakota.php',
                data:{'country_id':provinsi},
                success:function(result){
                    $('#kota').html(result);

                }
            });
        }else{
            $('#kota').val(hargaBarang);
        }
    });
</script>