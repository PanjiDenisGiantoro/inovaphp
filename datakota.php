<?php

include_once "library/inc.connection.php";

$country_id=!empty($_POST['country_id'])?$_POST['country_id']:'';
if(!empty($country_id))
{

    $koneksidb	= mysqli_connect('localhost', 'root','','inovaklinik');
    $query="SELECT * from kota WHERE id_provinsi='$country_id'";
    $bacaQry = mysqli_query($koneksidb,$query);
    $myData = mysqli_fetch_array($bacaQry);


    
    echo "<option value='".$myData['id']."'>".$myData['namakota']."</option><br>";

}

?>