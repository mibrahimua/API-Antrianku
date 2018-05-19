<?php
require_once('config.php');



header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

$records = array("error" => FALSE);

if(isset($_GET['kd_rm'])&&isset($_GET['nick'])&&isset($_GET['tgl_antri'])) {

 $kd_rm = $_GET['kd_rm'];

 //$kd_rm2 = $_POST['kd_rm'];

 //$kd_poli = $_POST['kd_poli'];

 $tgl_antri = $_GET['tgl_antri'];

 $nick = $_GET['nick'];

 //$nick2 = $_POST['nick'];

 //$telp_pasien = $_POST['telp_pasien'];

 //$penjamin = $_POST['penjamin'];

$tgl1 = explode('/', $tgl_antri);
$tgl2 = $tgl1[2].'-'.$tgl1[1].'-'.$tgl1[0];
	

						function getRMFormat($rm){
						if(strlen($rm)< 11){
							$inputRm = strval(preg_replace("/[^A-Za-z0-9 ]/",'',$rm));
							//print $inputRm;
							$setInputRm = addZero($inputRm);
							//print $setInputRm;
							$rmFormat = substr($setInputRm,0,2).'-'.substr($setInputRm,2,2).'-'.substr($setInputRm,4,2).'-'.substr($setInputRm,6,2);
							//print $rmFormat;
							return $rmFormat;
						}
					};

							function addZero($input){
						if(strlen($input) >=8){
							//alert(input);
							return $input;
						}
						else {
							$input ='0'.$input;
							//print $input;
							$it = addZero($input);
							return $it;
						}
					}
					$newRm = getRMFormat($kd_rm);
					//$newRm2 = getRMFormat($kd_rm2);
					//print $newRm;
					
					
					
					

  

$sql = "SELECT kd_rm,nick,tgl_antri FROM ma_antrian WHERE kd_rm = '$newRm' AND nick = '$nick' AND tgl_antri = '$tgl2' AND verifikasi = 'B'";
$result = mysqli_query($con,$sql) or die ("Query error: " . mysqli_error());

$records = array();

if(($row = mysqli_fetch_array($result))) {

 $records["error"] = TRUE;
 $records["value"] = "ada";
 $records["message"] = "Maaf No RM ".$kd_rm.  " Telah Terdaftar Pada Tanggal ".$tgl_antri." ,Mohon Untuk Dapat Menunggu Balasan Dari Operator Kami";
}else{
 
 $records["error"] = FALSE;
 $records["value"] = "tidak";
 $records["message"] = "Tidak ada jadwal periksa";

 //$sql = "INSERT INTO ma_antrian (tgl_antri,kd_rm,telp_pasien,nick,kd_poli,penjamin) 
 //VALUES ('$tgl2','$newRm2','$telp_pasien','$nick2','$kd_poli','$penjamin')";
 //$result = mysqli_query($con,$sql) or die ("Query error: " . mysqli_error());
}
mysqli_close($con);
$data = json_encode($records);
echo $data;
//echo $_GET['jsoncallback'] . '(' . json_encode($records) . ');';
}
?>