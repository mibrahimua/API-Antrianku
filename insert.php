<?php

require_once('config.php');

$kd_rm = $_POST['kd_rm'];
 $kd_poli = $_POST['kd_poli'];
 $tgl_antri = $_POST['tgl_antri'];
 $nick = $_POST['nick'];
 $telp_pasien = $_POST['telp_pasien'];
 $penjamin = $_POST['penjamin'];

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
 
 
 

$tgl1 = explode('/', $tgl_antri);
$tgl2 = $tgl1[2].'-'.$tgl1[1].'-'.$tgl1[0];
 $Sql_Query = "INSERT INTO ma_antrian (tgl_antri,kd_rm,telp_pasien,nick,kd_poli,penjamin) 
 VALUES ('$tgl2','$newRm','$telp_pasien','$nick','$kd_poli','$penjamin')";
 
 if(mysqli_query($con,$Sql_Query)){
 
 echo 'Data Submit Successfully';
 $response["message"] = "Tidak ada jadwal periksa";
			echo json_encode($response);
 
 }
 else{
 
 echo 'Try Again';
 
 }
 mysqli_close($con);
?>