<?php
include_once "../library/inc.seslogin.php";

if(isset($_GET['Aksi'])){
	if(trim($_GET['Aksi'])=="Hapus"){
		$id			= $_GET['id'];
		$userLogin	= $_SESSION['SES_LOGIN'];
		
		$mySql = "DELETE FROM tmp_rawat WHERE id='$id' AND kd_petugas='$userLogin'";
		mysqli_query($koneksidb,$mySql);
	}
	if(trim($_GET['Aksi'])=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

if(isset($_POST['btnTambah'])){
	$pesanError = array();
	if (trim($_POST['cmbDokter'])=="KOSONG") {
		$pesanError[] = "Data <b>Nama Pegawai</b> belum dipilih, harus Anda pilih dari combo !";
	}
	if (trim($_POST['cmbTindakan'])=="KOSONG") {
		$pesanError[] = "Data <b>Nama Tindakan</b> belum dipilih, harus Anda pilih dari combo !";		
	}


	$txtNomorRM	= $_POST['txtNomorRM'];
	
	$cmbDokter	= $_POST['cmbDokter'];
	$cmbTindakan= $_POST['cmbTindakan'];
	
	$txtHarga	= $_POST['txtHarga'];
	$txtHarga	= str_replace("'","&acute;",$txtHarga);
	$txtHarga	= str_replace(".","",$txtHarga);

	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {

		$tmpSql 	= "INSERT INTO tmp_rawat (kd_tindakan, harga, kd_pegawai, kd_petugas) 
					   VALUES ('$cmbTindakan', '$txtHarga','$cmbDokter', '".$_SESSION['SES_LOGIN']."')";
		mysqli_query($koneksidb,$tmpSql);

	}
}

if(isset($_POST['btnSimpan'])){
	$pesanError = array();
	if (trim($_POST['txtNomorRM'])=="") {
		$pesanError[] = "Data <b>Nomor Rekam Medik (RM)</b> belum diisi, silahkan klik <b>daftar pasien</b> !";		
	}
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Rawat</b> belum diisi, silahkan pilih pada kalender !";		
	}
	if (trim($_POST['txtUangBayar'])==""  or ! is_numeric(trim($_POST['txtUangBayar']))) {
		$pesanError[] = "Data <b> Uang Bayar (Rp)</b> belum diisi, silahkan isi dengan uang (Rp) !";		
	}

	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_rawat WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysqli_query($koneksidb,$tmpSql);
	$tmpData = mysqli_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR TINDAKAN MASIH KOSONG</b>, Daftar item tindakan belum ada yang dimasukan, <b>minimal 1 data</b>.";
	}

	$txtTanggal 	= $_POST['txtTanggal'];
	$txtNomorRM		= $_POST['txtNomorRM'];
	$txtPasien		= $_POST['txtPasien'];
	$txtDiagnosa	= $_POST['txtDiagnosa'];
	$txtUangBayar	= $_POST['txtUangBayar'];
			
						
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
        $query = "SELECT max(no_rawat) as maxKode FROM rawat_tindakan";
        $hasil = mysqli_query($koneksidb,$query);
        $data = mysqli_fetch_array($hasil);
        $kodepetugas = $data['maxKode'];
        $noUrut = (int) substr($kodepetugas, 3, 3);
        $noUrut++;
        $char = "R";
        $noTransaksi = $char . sprintf("%03s", $noUrut);
		$tanggal	= InggrisTgl($_POST['txtTanggal']);
		$userLogin	= $_SESSION['SES_LOGIN'];
		
		// Skrip menyimpan data ke tabel transaksi utama
		$mySql	= "INSERT INTO rawat SET 
						no_rawat='$noTransaksi', 
						tgl_rawat='$tanggal', 
						nomor_rm='$txtNomorRM', 
						nm_pasien='$txtPasien',
						hasil_diagnosa='$txtDiagnosa', 
						uang_bayar='$txtUangBayar', 
						kd_petugas='$userLogin'";
		mysqli_query($koneksidb,$mySql);

		$tmpSql ="SELECT * FROM tmp_rawat WHERE kd_petugas='$userLogin'";
		$tmpQry = mysqli_query($koneksidb,$tmpSql);
		while ($tmpData = mysqli_fetch_array($tmpQry)) {
			$kodeTindakan	= $tmpData['kd_tindakan'];
			$hargaTindakan	= $tmpData['harga'];
			$kodeDokter		= $tmpData['kd_pegawai'];

			$itemSql = "INSERT INTO rawat_tindakan SET
							 tgl_tindakan='$tanggal', 
							 no_rawat='$noTransaksi', 
							 kd_tindakan='$kodeTindakan', 
							 harga='$hargaTindakan', 
							 id_tindakan='$noTransaksi', 
							 kd_pegawai='$kodeDokter' ";
			mysqli_query($koneksidb,$itemSql);
		}
		$hapusSql = "DELETE FROM tmp_rawat WHERE kd_petugas='$userLogin'";
		mysqli_query($koneksidb,$hapusSql);
		
		echo "<script>";
		echo "window.open('rawat_nota.php?nomorRawat=$noTransaksi', width=330,height=330,left=100, top=25)";
		echo "</script>";
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=index.php'>";

	}	
}

// Membaca Nomor RM data Pasien
$NomorRM= isset($_GET['NomorRM']) ?  $_GET['NomorRM'] : '';
$mySql	= "SELECT nomor_rm, nm_pasien FROM pasien WHERE nomor_rm='$NomorRM'";
$myQry	= mysqli_query($koneksidb,$mySql);
$myData = mysqli_fetch_array($myQry);
$dataPasien		= $myData['nm_pasien'];

# Kode pasien
if($NomorRM=="") {
	$NomorRM= isset($_POST['txtNomorRM']) ? $_POST['txtNomorRM'] : '';
}

# MEMBACA DATA DARI FORM UTAMA TRANSAKSI, Nilai datanya dimasukkan kembali ke Form utama DATA TRANSAKSI
$query = "SELECT max(no_rawat) as maxKode FROM rawat_tindakan";
$hasil = mysqli_query($koneksidb,$query);
$data = mysqli_fetch_array($hasil);
$kodepetugas = $data['maxKode'];
$noUrut = (int) substr($kodepetugas, 3, 3);
$noUrut++;
$char = "R";
$noTransaksi = $char . sprintf("%03s", $noUrut);
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataDiagnosa	= isset($_POST['txtDiagnosa']) ? $_POST['txtDiagnosa'] : '';
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
$dataDokter		= isset($_POST['cmbDokter']) ? $_POST['cmbDokter'] : '';
$dataTindakan	= isset($_POST['cmbTindakan']) ? $_POST['cmbTindakan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" cellspacing="1"  class="table-list">
    <tr>
      <td colspan="3"><h1> PEMERIKSAAN PASIEN </h1></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA PEMERIKSAAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="26%"><strong>No. Periksa </strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="73%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl. Periksa</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" /></td>
    </tr>
    <tr>
      <td><strong>Nomor Daftar Pasien </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNomorRM" value="<?php echo $NomorRM; ?>" size="23" maxlength="20" />
        * pilih dari <a href="?page=Pencarian-Pasien" target="_self">Daftar Pasien</a>, lalu klik menu <strong>Periksa</strong> </td>
    </tr>
    <tr>
      <td><strong>Nama Pasien </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtPasien" value="<?php echo $dataPasien; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Hasil Diagnosa Dokter </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtDiagnosa" value="<?php echo $dataDiagnosa; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>INPUT TINDAKAN </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Pegawai </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbDokter">
          <option value="KOSONG">....</option>
          <?php
	  $bacaSql = "SELECT * FROM pegawai ORDER BY kd_pegawai";
	  $bacaQry = mysqli_query($koneksidb,$bacaSql);
	  while ($bacaData = mysqli_fetch_array($bacaQry)) {
		if ($bacaData['kd_pegawai'] == $dataDokter) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[kd_pegawai]' $cek>[ $bacaData[kd_pegawai] ]  $bacaData[nm_pegawai]</option>";
	  }
	  ?>
        </select> </td>
    </tr>
    <tr>
      <td><strong>Tindakan Pasien </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbTindakan" id="cmbTindakan">
        <option value="KOSONG">....</option>
        <?php
	  $bacaSql = "SELECT * FROM tindakan ORDER BY kd_tindakan";
	  $bacaQry = mysqli_query($koneksidb,$bacaSql);
	  while ($bacaData = mysqli_fetch_array($bacaQry)) {
		if ($bacaData['kd_tindakan'] == $dataTindakan) {
			$cek = " selected";
		} else { $cek=""; }
		
		$harga = format_angka($bacaData['harga']);
		echo "<option value='$bacaData[kd_tindakan]' $cek>[ $bacaData[kd_tindakan] ]  $bacaData[nm_tindakan] | $harga</option>";
	  }
	  ?>
      </select> </td>
    </tr>
    <tr>
      <td><strong>Harga Tindakan (Rp) </strong></td>
      <td><strong>:</strong></td>
      <td><b>

              <select name="txtHarga" id="txtHarga" class="form-control" style="width: 40%">
                  <option value="">.....</option>
              </select>
        <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
      <tr>
          <td><strong>Uang Bayar </strong></td>
          <td><strong>:</strong></td>
          <td><input name="txtUangBayar" value="<?php echo $dataUangBayar; ?>" size="23" maxlength="23" id="txtUangBayar"onchange="hitung();"/></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
    </tr>
  </table>
  <br>
  <table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <th colspan="6"><strong>DAFTAR TINDAKAN </strong></th>
    </tr>
    <tr>
      <td width="27" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="58" bgcolor="#CCCCCC"><strong>Kode </strong></td>
      <td width="365" bgcolor="#CCCCCC"><strong>Nama Tindakan </strong></td>
      <td width="190" bgcolor="#CCCCCC"><strong>Pegawai</strong></td>
      <td width="90" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
      <td width="39">&nbsp;</td>
    </tr>
    <?php
	// Query SQL menampilkan data Tindakan dalam TMP_RAWAT
	$tmpSql ="SELECT tmp_rawat.*, tindakan.nm_tindakan, pegawai.nm_pegawai FROM tmp_rawat
			  LEFT JOIN tindakan ON tmp_rawat.kd_tindakan=tindakan.kd_tindakan 
			  LEFT JOIN pegawai ON tmp_rawat.kd_pegawai=pegawai.kd_pegawai
			  WHERE tmp_rawat.kd_petugas='".$_SESSION['SES_LOGIN']."' ORDER BY id";
	$tmpQry = mysqli_query($koneksidb,$tmpSql);
	$nomor=0;  $totalHarga = 0; 
	while($tmpData = mysqli_fetch_array($tmpQry)) {
		$nomor++;
		$totalHarga	= $totalHarga +  $tmpData['harga'];
	?>
	  <tr>
		<td><?php echo $nomor; ?></td>
		<td><?php echo $tmpData['kd_tindakan']; ?></td>
		<td><?php echo $tmpData['nm_tindakan']; ?></td>
		<td><?php echo $tmpData['nm_pegawai']; ?></td>
		<td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
		<td><a href="?Aksi=Hapus&id=<?php echo $tmpData['id']; ?>" target="_self">Delete</a></td>
	  </tr>
    <?php } ?>
    <tr>
      <td colspan="4" align="right"><b> GRAND TOTAL  : </b></td>
      <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($totalHarga); ?></strong></td>
      <td align="right" hidden bgcolor="#CCCCCC"><strong><input id="a" type="text" hidden value="<?php echo $totalHarga ?>"onchange="hitung();"></strong></td>
      <td>&nbsp;</td>
    </tr>
      <tr>
          <td colspan="4" align="right"><b> Kembalian  : </b></td>
          <td align="right" bgcolor="#CCCCCC"><strong>Rp. <input type="text" class="c"></strong></td>
          <td>&nbsp;</td>
      </tr>
  </table>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.3.2/select2.min.js"></script>
<script>
    $(document).on('change','#cmbTindakan', function(){
        var tindakanid = $(this).val();
        if(tindakanid){
            $.ajax({
                type:'POST',
                url:'dataharga.php',
                data:{'country_id':tindakanid},
                success:function(result){
                    $('#txtHarga').html(result);

                }
            });
        }else{
            $('#txtHarga').val(hargaBarang);
        }
    });
</script>
<script>
    function hitung() {
        var a = $('#txtUangBayar').val();
        var b = $('#a').val();
        c = a - b; //a kali b
        console.log(a - b);
        $(".c").val(c);
    }
</script>
