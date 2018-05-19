<?php
$alamat = "Perum Korpri Sendangguwo Baru IV No 12 RT/RW 07/07 Semarang";
//$alamat = "KAYUAPAK RT.02 RW VI AYU VI    ";
//$alamat = "KAYUAPAK RT.02 RW VI AYU VI AYU VI AYU";

$panjang_karakter = strlen($alamat);
echo "panjang karakter = ".$panjang_karakter."</br>";
if($panjang_karakter <= 20){
	$minus = 7;
	$kata_depan = 4;
	echo "minus 7"."</br>";
}elseif($panjang_karakter <= 25){
	$minus = 10;
	$kata_depan = 12;
	echo "minus 110"."</br>";
}
elseif($panjang_karakter <= 30){
	$minus = 18;
	$kata_depan = 13;
	echo "minus 18"."</br>";
}else{
	$minus = 18;
	$kata_depan = 13;
	echo "minus 18 else"."</br>";
}
$count =$panjang_karakter - $minus;
$alamatedit = substr_replace($alamat, str_repeat('*', $count), $kata_depan, $count);
echo $alamatedit;

?>