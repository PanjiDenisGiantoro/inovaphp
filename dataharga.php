<?php

include_once "../library/inc.connection.php";

$country_id=!empty($_POST['country_id'])?$_POST['country_id']:'';
if(!empty($country_id))
{

    $koneksidb	= mysqli_connect('localhost', 'root','','inovaklinik');
    $query="SELECT kd_tindakan, harga from tindakan WHERE country_id='$country_id'";
    $bacaQry = mysqli_query($koneksidb,$query);
    $myData = mysqli_fetch_array($bacaQry);


    
    echo "<option value='".$myData['harga']."'>".$myData['harga']."</option><br>";

}

?>