<?php
include_once "library/inc.seslogin.php";

if (isset($_POST['btnSimpan'])) {
    $pesanError = array();
    if (trim($_POST['txtNama']) == "") {
        $pesanError[] = "Data <b>Nama User</b> tidak boleh kosong !";
    }
    if (trim($_POST['txtTelepon']) == "") {
        $pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";
    }
    if (trim($_POST['txtUsername']) == "") {
        $pesanError[] = "Data <b>Username</b> tidak boleh kosong !";
    }
    if (trim($_POST['txtPassword']) == "") {
        $pesanError[] = "Data <b>Password</b> tidak boleh kosong !";
    }
    if (trim($_POST['cmbLevel']) == "KOSONG") {
        $pesanError[] = "Data <b>Level login</b> belum dipilih !";
    }

    $txtNama = $_POST['txtNama'];
    $txtUsername = $_POST['txtUsername'];
    $txtPassword = $_POST['txtPassword'];
    $txtTelepon = $_POST['txtTelepon'];
    $cmbLevel = $_POST['cmbLevel'];

    $cekSql = "SELECT * FROM petugas WHERE username='$txtUsername'";
    $cekQry = mysqli_query($koneksidb, $cekSql);
    if (mysqli_num_rows($cekQry) >= 1) {
        $pesanError[] = "Username <b> $txtUsername </b> sudah ada, ganti dengan yang lain";
    }

    if (count($pesanError) >= 1) {
        echo "<div class='mssgBox'>";
        echo "<img src='images/attention.png'> <br><hr>";
        $noPesan = 0;
        foreach ($pesanError as $indeks => $pesan_tampil) {
            $noPesan++;
            echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
        }
        echo "</div> <br>";
    } else {
        $query = "SELECT max(kd_petugas) as maxKode FROM petugas";
        $hasil = mysqli_query($koneksidb,$query);
        $data = mysqli_fetch_array($hasil);
        $kodepetugas = $data['maxKode'];
        $noUrut = (int) substr($kodepetugas, 3, 3);
        $noUrut++;
        $char = "P";
        $kodepetugas1 = $char . sprintf("%03s", $noUrut);
        $kodeBaru = buatKode("petugas", "P");
        $mySql = "INSERT INTO petugas (kd_petugas, nm_petugas, no_telepon, 
										 username, password, level)
						VALUES ('$kodepetugas1', 
								'$txtNama', 
								'$txtTelepon', 
								'$txtUsername', 
								MD5('$txtPassword'), 
								'$cmbLevel')";
        $myQry = mysqli_query($koneksidb, $mySql);
        if ($myQry) {
            echo "<meta http-equiv='refresh' content='0; url=?page=Petugas-Data'>";
        }
       var_dump("$mySql");
    }
}

$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataUsername = isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataPassword = isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
$dataLevel = isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
?>
<?php

$query = "SELECT max(kd_petugas) as maxKode FROM petugas";
$hasil = mysqli_query($koneksidb,$query);
$data = mysqli_fetch_array($hasil);
$kodepetugas = $data['maxKode'];
$noUrut = (int) substr($kodepetugas, 3, 3);
$noUrut++;
$char = "P";
$kodepetugas1 = $char . sprintf("%03s", $noUrut);
?>
<div class="col-8">
    <div class="card">
        <div class="card-body">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
                    <br>
                    <tr>
                        <th height="28" colspan="3" ><b>TAMBAH DATA USER </b></th>
                    </tr>
                    <tr>
                        <td width="181"><b>Kode</b></td>
                        <td width="5"><b>:</b></td>
                        <td width="1000"><input name="textfield"class="form-control" type="text" value="<?php echo $kodepetugas1; ?>" style="width: 10%"
                                                maxlength="10" readonly="readonly"/></td>
                    </tr>
                    <tr>
                        <td><b>Nama User </b></td>
                        <td><b>:</b></td>
                        <td><input name="txtNama" type="text"class="form-control" value="<?php echo $dataNama; ?>" style="width: 80%"
                                   maxlength="100"/></td>
                    </tr>
                    <tr>
                        <td><b>No. Telepon </b></td>
                        <td><b>:</b></td>
                        <td><input name="txtTelepon" type="text"class="form-control" value="<?php echo $dataTelepon; ?>"style="width: 60%"
                                   maxlength="20"/></td>
                    </tr>
                    <tr>
                        <td><b>Username</b></td>
                        <td><b>:</b></td>
                        <td><input name="txtUsername" type="text" value="<?php echo $dataUsername; ?>" style="width: 60%"
                                   maxlength="20"/></td>
                    </tr>
                    <tr>
                        <td><b>Password</b></td>
                        <td><b>:</b></td>
                        <td><input name="txtPassword"class="form-control" type="password" style="width:60%"  maxlength="20"/></td>
                    </tr>
                    <tr>
                        <td><b>Level</b></td>
                        <td><b>:</b></td>
                        <td><b>
                                <select name="cmbLevel"class="form-control"style="width: 50%" >
                                    <option value="KOSONG">....</option>
                                    <?php
                                    $pilihan = array("Klinik", "Apotek", "Admin");
                                    foreach ($pilihan as $nilai) {
                                        if ($dataLevel == $nilai) {
                                            $cek = " selected";
                                        } else {
                                            $cek = "";
                                        }
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
                            <input type="submit" name="btnSimpan"class="btn btn-primary" value=" Simpan "/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
