<?php
include_once "library/inc.seslogin.php";

if (isset($_POST['btnSimpan'])) {
    $pesanError = array();
    if (trim($_POST['txtNama']) == "") {
        $pesanError[] = "Data <b>Nama Tindakan</b> tidak boleh kosong !";
    }
    if (trim($_POST['txtHarga']) == "") {
        $pesanError[] = "Data <b>Harga (Rp.)</b> tidak boleh kosong !";
    }

    $txtNama = $_POST['txtNama'];
    $txtHarga = $_POST['txtHarga'];

    $cekSql = "SELECT * FROM tindakan WHERE nm_tindakan='$txtNama' AND NOT(nm_tindakan='" . $_POST['txtLama'] . "')";
    $cekQry = mysqli_query($koneksidb, $cekSql);
    if (mysqli_num_rows($cekQry) >= 1) {
        $pesanError[] = "Maaf, Tindakan <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
        $mySql = "UPDATE tindakan SET nm_tindakan='$txtNama', harga='$txtHarga' WHERE kd_tindakan ='" . $_POST['txtKode'] . "'";
        $myQry = mysqli_query($koneksidb, $mySql);
        if ($myQry) {
            echo "<meta http-equiv='refresh' content='0; url=?page=Tindakan-Data'>";
        }
        exit;
    }
}

$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtKode'];
$mySql = "SELECT * FROM tindakan WHERE kd_tindakan='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql);
$myData = mysqli_fetch_array($myQry);

$dataKode = $myData['kd_tindakan'];
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_tindakan'];
$dataHarga = isset($_POST['txtHarga']) ? $_POST['txtHarga'] : $myData['harga'];
?>
<div class="col-8">
    <div class="card">
        <div class="card-body">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                <table width="100%" class="table-list" border="0" cellpadding="4" cellspacing="1">
                    <tr>
                        <th colspan="3" scope="col"><b>UBAH TINDAKAN</b></th>
                    </tr>
                    <tr>
                        <td width="181"><strong>Kode</strong></td>
                        <td width="3">:</td>
                        <td width="1019"><input name="textfield" value="<?php echo $dataKode; ?>" size="10"
                                                maxlength="10" readonly="readonly"/>
                            <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>"/></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Tindakan </strong></td>
                        <td>:</td>
                        <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100"/>
                            <input name="txtLama" type="hidden" value="<?php echo $myData['nm_tindakan']; ?>"/></td>
                    </tr>
                    <tr>
                        <td><strong>Harga (Rp.) </strong></td>
                        <td>:</td>
                        <td><input name="txtHarga" value="<?php echo $dataHarga; ?>" size="20" maxlength="12"/></td>
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