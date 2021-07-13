<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])){
	$mySql = "DELETE FROM tindakan WHERE kd_tindakan='".$_GET['Kode']."'";
	$myQry = mysqli_query($koneksidb,$mySql);
	if($myQry){
		echo "<meta http-equiv='refresh' content='0; url=?page=Tindakan-Data'>";
	}
}
else {
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>