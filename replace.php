<?php
$alamat = "Jalan Mangga Timur, Kariyadi Semarang";
$jumlah_sensor=7;
$index=12;
 
//ambil 4 angka di tengah yan akan disensor
$censored = mb_substr($alamat, $index, $jumlah_sensor);
 
//pecah kelompok angka pertama dan terakhir
$alamat2=explode($censored,$alamat);

 
//gabung angka perama dan terakhir dengan angka tengah yang telah di sensor
$alamatedit=$alamat2[0]."_______".$alamat2[1];
 
//tampilkan
echo $alamatedit;
?>