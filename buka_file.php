<?php
# KONTROL MENU PROGRAM
if($_GET) {
	// Jika mendapatkan variabel URL ?page
	switch($_GET['page']){				
		case '' :
			if(!file_exists ("login.php")) die ("Empty Main Page!");
			include "login.php";	break;
			
		case 'Halaman-Utama' :
			if(!file_exists ("main.php")) die ("Sorry Empty Page!"); 
			include "main.php";	break;
			
		case 'Login' :
			if(!file_exists ("login.php")) die ("Sorry Empty Page!"); 
			include "login.php"; break;
			
		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("Sorry Empty Page!"); 
			include "login_validasi.php"; break;
			
		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("Sorry Empty Page!"); 
			include "login_out.php"; break;		

		# TINDAKAN / PAKET TINDAKAN
		case 'Tindakan-Data' :
			if(!file_exists ("tindakan_data.php")) die ("Sorry Empty Page!"); 
			include "tindakan_data.php"; break;		
		case 'Tindakan-Add' :
			if(!file_exists ("tindakan_add.php")) die ("Sorry Empty Page!"); 
			include "tindakan_add.php";	break;		
		case 'Tindakan-Delete' :
			if(!file_exists ("tindakan_delete.php")) die ("Sorry Empty Page!"); 
			include "tindakan_delete.php"; break;		
		case 'Tindakan-Edit' :
			if(!file_exists ("tindakan_edit.php")) die ("Sorry Empty Page!"); 
			include "tindakan_edit.php"; break;	



		case 'Pegawai-Data' :
			if(!file_exists ("pegawai_data.php")) die ("Sorry Empty Page!");
			include "pegawai_data.php";	 break;
		case 'Pegawai-Add' :
			if(!file_exists ("pegawai_add.php")) die ("Sorry Empty Page!");
			include "pegawai_add.php";	 break;
		case 'Pegawai-Delete' :
			if(!file_exists ("pegawai_delete.php")) die ("Sorry Empty Page!");
			include "pegawai_delete.php"; break;
		case 'Pegawai-Edit' :
			if(!file_exists ("pegawai_edit.php")) die ("Sorry Empty Page!");
			include "pegawai_edit.php"; break;


		# PETUGAS KLINIK
		case 'Petugas-Data' :
			if(!file_exists ("petugas_data.php")) die ("Sorry Empty Page!");
			include "petugas_data.php";	 break;
		case 'Petugas-Add' :
			if(!file_exists ("petugas_add.php")) die ("Sorry Empty Page!");
			include "petugas_add.php";	 break;
		case 'Petugas-Delete' :
			if(!file_exists ("petugas_delete.php")) die ("Sorry Empty Page!");
			include "petugas_delete.php"; break;
		case 'Petugas-Edit' :
			if(!file_exists ("petugas_edit.php")) die ("Sorry Empty Page!");
			include "petugas_edit.php"; break;


		# PASIEN
		case 'Pasien-Data' :
			if(!file_exists ("pasien_data.php")) die ("Sorry Empty Page!"); 
			include "pasien_data.php"; break;		
		case 'Pasien-Add' :
			if(!file_exists ("pasien_add.php")) die ("Sorry Empty Page!"); 
			include "pasien_add.php"; break;
		case 'Pasien-Delete' :
			if(!file_exists ("pasien_delete.php")) die ("Sorry Empty Page!");
			include "pasien_delete.php"; break;
		case 'Pasien-Edit' :
			if(!file_exists ("pasien_edit.php")) die ("Sorry Empty Page!");
			include "pasien_edit.php"; break;

			
		# OBAT
		case 'Obat-Data' :
			if(!file_exists ("obat_data.php")) die ("Sorry Empty Page!"); 
			include "obat_data.php"; break;		
		case 'Obat-Add' :
			if(!file_exists ("obat_add.php")) die ("Sorry Empty Page!"); 
			include "obat_add.php"; break;		
		case 'Obat-Delete' :
			if(!file_exists ("obat_delete.php")) die ("Sorry Empty Page!"); 
			include "obat_delete.php"; break;		
		case 'Obat-Edit' :
			if(!file_exists ("obat_edit.php")) die ("Sorry Empty Page!"); 
			include "obat_edit.php"; break;
			
		case 'Pencarian-Obat' :
			if(!file_exists ("pencarian_obat.php")) die ("Sorry Empty Page!"); 
			include "pencarian_obat.php"; break;


        # wilayah
        case 'Wilayah-Data' :
            if(!file_exists ("wilayah_data.php")) die ("Sorry Empty Page!");
            include "wilayah_data.php"; break;
        case 'Wilayah-Add' :
            if(!file_exists ("wilayah_add.php")) die ("Sorry Empty Page!");
            include "wilayah_add.php"; break;
        case 'Wilayah-Delete' :
            if(!file_exists ("wilayah_delete.php")) die ("Sorry Empty Page!");
            include "wilayah_delete.php"; break;
        # kota
        case 'Kota-Data' :
            if(!file_exists ("kota_data.php")) die ("Sorry Empty Page!");
            include "kota_data.php"; break;
        case 'Kota-Add' :
            if(!file_exists ("kota_add.php")) die ("Sorry Empty Page!");
            include "wilayah_add.php"; break;
        case 'Kota-Delete' :
            if(!file_exists ("kota_delete.php")) die ("Sorry Empty Page!");
            include "kota_delete.php"; break;


        # grafik
        case 'Grafik-Data' :
            if(!file_exists ("grafik_data.php")) die ("Sorry Empty Page!");
            include "grafik_data.php"; break;
    }
}
else {
	if(!file_exists ("main.php")) die ("Empty Main Page!");
	include "main.php";	
}
?>