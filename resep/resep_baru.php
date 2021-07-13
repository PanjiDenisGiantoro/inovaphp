<?php
include_once "../library/inc.seslogin.php";

if(isset($_GET['Aksi'])){
	if(trim($_GET['Aksi'])=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_resep WHERE id='".$_GET['id']."' AND kd_petugas='".$_SESSION['SES_LOGIN']."'";
		mysqli_query($koneksidb,$mySql);
	}
	if(trim($_GET['Aksi'])=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}


if(isset($_POST['btnTambah'])){
	$pesanError = array();
	if (trim($_POST['txtKodeObat'])=="") {
		$pesanError[] = "Data <b>Kode Obat belum diisi</b>, ketik Kode dari Keyboard atau dari <b>Barcode Reader</b> !";		
	}
	if (trim($_POST['txtJumlah'])=="" or ! is_numeric(trim($_POST['txtJumlah']))) {
		$pesanError[] = "Data <b>Jumlah Obat (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	
	$txtKodeObat	= $_POST['txtKodeObat'];
	$txtKodeObat	= str_replace("'","&acute;", $txtKodeObat);
	$txtJumlah	= $_POST['txtJumlah'];

	$cekSql	= "SELECT stok FROM obat WHERE kd_obat='$txtKodeObat'";
	$cekQry = mysqli_query($koneksidb,$cekSql);
	$cekRow = mysqli_fetch_array($cekQry);
	if ($cekRow['stok'] < $txtJumlah) {
		$pesanError[] = "Stok Obat untuk Kode <b>$txtKodeObat</b> adalah <b> $cekRow[stok]</b>, tidak dapat dijual!";
	}
			
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
$mySql ="SELECT * FROM obat WHERE kd_obat='$txtKodeObat'";
$myQry = mysqli_query($koneksidb,$mySql);
$myRow = mysqli_fetch_array($myQry);
if (mysqli_num_rows($myQry) >= 1) {
	// Membaca kode obat/ obat
	$kodeObat	= $myRow['kd_obat'];
	
	// Jika Kode ditemukan, masukkan data ke Keranjang (TMP)
	$tmpSql 	= "INSERT INTO tmp_resep (kd_obat, jumlah,  kd_petugas) 
				VALUES ('$kodeObat', '$txtJumlah',  '".$_SESSION['SES_LOGIN']."')";
	mysqli_query($koneksidb,$tmpSql);
}
}

}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	$pesanError = array();
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada kalender !";		
	}
	if (trim($_POST['txtUangBayar'])==""  or ! is_numeric(trim($_POST['txtUangBayar']))) {
		$pesanError[] = "Data <b> Uang Bayar</b> belum diisi, isi dengan uang (Rp) !";		
	}
	if (trim($_POST['txtUangBayar']) < trim($_POST['txtTotBayar'])) {
		$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
						 Total belanja adalah <b> Rp. ".format_angka($_POST['txtTotBayar'])."</b>";		
	}
	
	# Periksa apakah sudah ada obat yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_resep WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysqli_query($koneksidb,$tmpSql);
	$tmpData = mysqli_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR OBAT MASIH KOSONG</b>, belum ada obat yang dimasukan, <b>minimal 1 obat</b>.";
	}
	
	# Baca variabel from
	$txtTanggal 	= $_POST['txtTanggal'];
	$txtNoPasien	= $_POST['txtNoPasien'];
	$txtPelanggan	= $_POST['txtPelanggan'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtUangBayar	= $_POST['txtUangBayar'];
			
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
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
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel penjualan dan penjualan_item
        $query = "SELECT max(no_penjualan) as maxKode FROM resep";
        $hasil = mysqli_query($koneksidb,$query);
        $data = mysqli_fetch_array($hasil);
        $kodepetugas = $data['maxKode'];
        $noUrut = (int) substr($kodepetugas, 3, 3);
        $noUrut++;
        $char = "PR";
        $noTransaksi = $char . sprintf("%03s", $noUrut);
		$mySql	= "INSERT INTO resep SET 
						no_penjualan='$noTransaksi', 
						tgl_penjualan='".InggrisTgl($_POST['txtTanggal'])."', 
						nomor_rm='$txtNoPasien',
						pelanggan='$txtPelanggan', 
						keterangan='$txtKeterangan', 
						uang_bayar='$txtUangBayar',
						kd_petugas='".$_SESSION['SES_LOGIN']."'";
		mysqli_query($koneksidb,$mySql);
		
		$tmpSql ="SELECT obat.*, tmp.jumlah FROM obat, tmp_resep As tmp
					WHERE obat.kd_obat = tmp.kd_obat AND tmp.kd_petugas='".$_SESSION['SES_LOGIN']."'";
		$tmpQry = mysqli_query($koneksidb,$tmpSql);
		while ($tmpData = mysqli_fetch_array($tmpQry)) {
			$dataKode 	= $tmpData['kd_obat'];
			$dataHargaM	= $tmpData['harga_modal'];
			$dataHargaJ	= $tmpData['harga_jual'];
			$dataJumlah	= $tmpData['jumlah'];
			
			$itemSql = "INSERT INTO resep_item SET 
									no_penjualan='$noTransaksi', 
									kd_obat='$dataKode', 
									harga_modal='$dataHargaM', 
									harga_jual='$dataHargaJ', 
									jumlah='$dataJumlah'";
			mysqli_query($koneksidb,$itemSql);
			
			// Skrip Update stok
			$stokSql = "UPDATE obat SET stok = stok - $dataJumlah WHERE kd_obat='$dataKode'";
			mysqli_query($koneksidb,$stokSql);
		}
		
		$hapusSql = "DELETE FROM tmp_resep WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
		mysqli_query($koneksidb,$hapusSql);
		
		echo "<script>";
		echo "window.open('resep_nota.php?noNota=$noTransaksi', width=330,height=330,left=100, top=25)";
		echo "</script>";
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=index.php'>";

	}	
}

$nomorpasien= isset($_GET['nomorpasien']) ?  $_GET['nomorpasien'] : '';
$mySql	= "SELECT no_rawat, nm_pasien FROM rawat WHERE no_rawat='$nomorpasien'";
$myQry	= mysqli_query($koneksidb,$mySql);
$myData = mysqli_fetch_array($myQry);
$dataPelanggan	= $myData['nm_pasien'];

if($nomorpasien=="") {
	$nomorpasien= isset($_POST['txtNoPasien']) ? $_POST['txtNoPasien'] : '';
}

$query = "SELECT max(no_penjualan) as maxKode FROM resep";
$hasil = mysqli_query($koneksidb,$query);
$data = mysqli_fetch_array($hasil);
$kodepetugas = $data['maxKode'];
$noUrut = (int) substr($kodepetugas, 3, 3);
$noUrut++;
$char = "PR";
$noTransaksi = $char . sprintf("%03s", $noUrut);
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" cellpadding="3" cellspacing="1"  class="table-list">
    <tr>
      <td colspan="3"><h1> PENERIMAAN RESEP OBAT </h1></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>DATA PENERIMAAN OBAT </strong></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="26%"><strong>No.Penerimaan </strong></td>
      <td width="2%"><strong>:</strong></td>
      <td width="72%"><input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="23" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl.Penerimaan </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" maxlength="23" /></td>
    </tr>
   <tr>
      <td><strong>No.Periksa Pasien</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoPasien" value="<?php echo $nomorpasien; ?>" size="20" maxlength="25" />
		 * pilih dari <a href="?page=Pencarian-Pasien" target="_self">Daftar Pasien</a>, lalu klik menu <strong>Proses</strong></td>
    </tr>
    <tr>
      <td><strong>Pasien</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtPelanggan" value="<?php echo $dataPelanggan; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Keterangan</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong>INPUT  OBAT </strong></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Kode Obat </strong></td>
      <td><strong>:</strong></td>
      <td><b>
              <select name="txtKodeObat" id="txtKodeObat">
                  <option value="sfsdf">dcscsdc</option>
                  <option value="sfsdf2">csdc</option>
                  <?php
                  $dataSql = "SELECT * FROM obat ORDER BY nm_obat";
                  $dataQry = mysqli_query($koneksidb,$dataSql);
                  while ($dataRow = mysqli_fetch_array($dataQry)) {

                      echo "<option value='$dataRow[kd_obat]'> $dataRow[nm_obat] ($dataRow[stok]) </option>";
                  }
                  ?>
              </select>
        <a href="?page=Pencarian-Obat" target="_blank">Pencarian Obat</a></b></td>
    </tr>
    <tr>
      <td><b>Jumlah </b></td>
      <td><b>:</b></td>
      <td><b>
        <input class="angkaC" name="txtJumlah" size="10" maxlength="4" value="1" 
				 onblur="if (value == '') {value = '1'}" 
				 onfocus="if (value == '1') {value =''}"/>
        <input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " />
      </b></td>
    </tr>
  </table>
  <br>
  <table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <th colspan="7">DAFTAR OBAT </th>
    </tr>
    <tr>
      <td width="29" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="85" bgcolor="#CCCCCC"><strong>Kode</strong></td>
      <td width="432" bgcolor="#CCCCCC"><strong>Nama Obat </strong></td>
      <td width="85" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
      <td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
      <td width="100" align="right" bgcolor="#CCCCCC"><strong>Sub Total(Rp) </strong></td>
      <td width="22" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
<?php
// Qury menampilkan data dalam Grid TMP_Penjualan 
$tmpSql ="SELECT obat.*, tmp.id, tmp.jumlah FROM obat, tmp_resep As tmp
		WHERE obat.kd_obat=tmp.kd_obat AND tmp.kd_petugas='".$_SESSION['SES_LOGIN']."'
		ORDER BY obat.kd_obat ";
$tmpQry = mysqli_query($koneksidb,$tmpSql);
$nomor=0;  $hargaDiskon = 0;   $totalBayar	= 0;  $jumlahobat	= 0;
while($tmpData = mysqli_fetch_array($tmpQry)) {
	$nomor++;
	$subSotal 	= $tmpData['jumlah'] * $tmpData['harga_jual'];
	$totalBayar	= $totalBayar + $subSotal;
	$jumlahobat	= $jumlahobat + $tmpData['jumlah'];
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_obat']; ?></b></td>
      <td><?php echo $tmpData['nm_obat']; ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga_jual']); ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?Aksi=Delete&id=<?php echo $tmpData['id']; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL   (Rp.) : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong><?php echo $jumlahobat; ?></strong></td>
      <td align="right" bgcolor="#F5F5F5" hidden><strong><?php echo format_angka($totalBayar); ?></strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong><input  onchange="hitung();" type="text" class="a" value="<?php echo $totalBayar ?>"></strong></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>UANG BAYAR (Rp.) : </strong></td>
      <td bgcolor="#F5F5F5"><input name="txtTotBayar" hidden value="<?php echo $totalBayar; ?>" /></td>
      <td bgcolor="#F5F5F5"><input class="b" name="txtUangBayar" onchange="hitung();" value="<?php echo $dataUangBayar; ?>" size="16" maxlength="16"/></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
      <tr>
          <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>UANG KEMBALIAN (Rp.) : </strong></td>
          <td></td>
          <td bgcolor="#F5F5F5"><input class="c" size="16" onchange="hitung();" maxlength="16"/></td>
          <td bgcolor="#F5F5F5">&nbsp;</td>
      </tr>

      <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="right"><input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.3.2/select2.min.js"></script>
<script>
    function hitung() {
        var a = $('.a').val();
        var b = $('.b').val();
        c = a - b; //a kali b
        console.log(a - b);
        $(".c").val(c);
    }
</script>
