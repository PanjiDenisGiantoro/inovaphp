<?php
$myHost	= "localhost";
$myUser	= "root";
$myPass	= "";
$myDbs	= "inovaklinik";
$koneksidb	= mysqli_connect($myHost, $myUser, $myPass);
if (! $koneksidb) {
  echo "Failed Connection !";
}

mysqli_select_db($koneksidb,$myDbs);
?>