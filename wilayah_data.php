<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM provinsi";
$pageQry = mysqli_query($koneksidb,$pageSql);
$jml	 = mysqli_num_rows($pageQry);
$max	 = ceil($jml/$row);

if(isset($_POST['btnSimpan'])){
$pesanError = array();
if (trim($_POST['textfield'])=="") {
    $pesanError[] = "Data <b>Nama provinsi</b> tidak boleh kosong !";
}

$txtNama		= $_POST['textfield'];
$cekSql="SELECT * FROM provinsi WHERE namaprovinsi='$txtNama'";
$cekQry=mysqli_query($koneksidb,$cekSql);
if(mysqli_num_rows($cekQry)>=1){
    $pesanError[] = "Maaf, provinsi <b> $txtNama </b> sudah ada, ganti dengan yang lain";
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
}else {
    # SIMPAN DATA KE DATABASE.
    // Jika tidak menemukan error, simpan data ke database
    $mySql	= "INSERT INTO provinsi (namaprovinsi) 
					VALUES ('$txtNama')";
    $myQry	= mysqli_query($koneksidb,$mySql);
    if($myQry){
        echo "<meta http-equiv='refresh' content='0; url=?page=Wilayah-Data'>";
    }
    var_dump("$mySql");
}
}
# Baca Variabel Form




$kodepegawai	= isset($_POST['textfield']) ? $_POST['textfield'] : '';
?>


<div class="row">
    <div class="col-lg-8">
        <h1 class="page-header">Data provinsi</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">

                        <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
                            <tr>
                                <th colspan="3"  scope="col">TAMBAH DATA WILAYAH </th>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <br>
                            </tr>

                            <tr>
                                <td width="16%"><strong>Provinsi</strong></td>
                                <td width="1%"><strong>:</strong></td>
                                <td width="83%"><input name="textfield" value="<?php echo $kodepegawai; ?>" class="form-control"style="width: 80%"  maxlength="100"/></td>
                            <tr>



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

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
        <table  class="table table-striped table-bordered table-hover" id="dataTables-example"  width="100%"cellspacing="1" cellpadding="3">


            <tr>
                <td colspan="2">
                    <div class="dataTable-wrapper">
                        <div class="table-responsive">
                            <table  class="table table-striped table-bordered table-hover" id="dataTables-example"  width="100%"cellspacing="1" cellpadding="3">
                                <tr>
                                    <th width="24" align="center"><strong>No</strong></th>
                                    <th width="189"><strong>Nama provinsi </strong></th>
                                    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
                                </tr>
                                <?php
                                $mySql = "SELECT * FROM provinsi ORDER BY namaprovinsi ASC LIMIT $hal, $row";
                                $myQry = mysqli_query($koneksidb,$mySql);
                                $nomor = 0;
                                while ($myData = mysqli_fetch_array($myQry)) {
                                    $nomor++;
                                    $Kode = $myData['id'];
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $myData['namaprovinsi']; ?></td>
                                        <td width="50" align="center"><a href="?page=Wilayah-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA WIlayah INI ... ?')">Delete</a></td>
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
                        echo " <a href='?page=Wilayah-Data&hal=$list[$h]'>$h</a> ";
                    }
                    ?></td>
            </tr>
        </table>

    </div>
        </div>
    </div>
</div>
