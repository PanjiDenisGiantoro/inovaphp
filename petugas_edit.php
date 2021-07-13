<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])){
	$pesanError = array();
	if (trim($_POST['txtKode'])=="") {
		$pesanError[] = "Data <b>Kode </b> tidak terbaca !";		
	}
	if (trim($_POST['txtNama'])=="") {
		$pesanError[] = "Data <b>Nama Petugas</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTelepon'])=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtUsername'])=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	if (trim($_POST['cmbLevel'])=="KOSONG") {
		$pesanError[] = "Data <b>Level login</b> belum dipilih !";		
	}
			
	$txtNama	= $_POST['txtNama'];
	$txtUsername= $_POST['txtUsername'];
	$txtPassword= $_POST['txtPassword'];
	$txtPassLama= $_POST['txtPassLama'];	
	$txtTelepon	= $_POST['txtTelepon'];	
	$cmbLevel	= $_POST['cmbLevel'];
	
	$cekSql="SELECT * FROM petugas WHERE username='$txtUsername' AND NOT(username='".$_POST['txtUsernameLm']."')";
	$cekQry=mysqli_query($koneksidb,$cekSql);
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "Username<b> $txtUsername </b> sudah ada, ganti dengan yang lain";
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
		if (trim($txtPassword)=="") {
			$sqlPasword = ", password='$txtPassLama'";
		}
		else {
			$sqlPasword = ",  password ='".md5($txtPassword)."'";
		}
		
		$mySql  = "UPDATE petugas SET nm_petugas='$txtNama', username='$txtUsername', 
					no_telepon='$txtTelepon', level='$cmbLevel'
					$sqlPasword  
					WHERE kd_petugas='".$_POST['txtKode']."'";
		$myQry=mysqli_query($koneksidb,$mySql);
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Petugas-Data'>";
		}
		exit;
	}	
}


$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode'];
$mySql	= "SELECT * FROM petugas WHERE kd_petugas='$Kode'";
$myQry	= mysqli_query($koneksidb,$mySql);
$myData = mysqli_fetch_array($myQry);

	$dataKode		= $myData['kd_petugas'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_petugas'];
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataTelepon	= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];
?>
<div class="col-8">
    <div class="card">
        <div class="card-body">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA PETUGAS </b></th>
    </tr>
    <tr>
      <td width="181"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="1000"> <input name="textfield"class="form-control" type="text"  value="<?php echo $dataKode; ?>" style="width: 10%"  maxlength="10"  readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><b>Nama Petugas </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text"class="form-control" value="<?php echo $dataNama; ?>" style="width: 80%"  maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input name="txtTelepon"class="form-control" type="text" value="<?php echo $dataTelepon; ?>" style="width: 60%"  maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td><input name="txtUsername"class="form-control" type="text"  value="<?php echo $dataUsername; ?>" style="width: 60%"  maxlength="20" />
      <input name="txtUsernameLm"class="form-control" type="hidden" value="<?php echo $myData['username']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword"class="form-control" type="password" style="width: 60%"  maxlength="20" />
      <input name="txtPassLama"class="form-control" type="hidden" value="<?php echo $myData['password']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel"style="width: 50%"class="form-control" >
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("Klinik", "Apotek", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
        </div>
    </div>
</div>
