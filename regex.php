<?php
$string = '00302840';
echo $string;
echo "</br>";
if(preg_match("/^0/", $string)) {
  echo 'String berawalan 0';
  echo "</br>";
  $sub_string=substr($string, -6);
  echo $sub_string;
  echo "</br>";
  if(preg_match("/-/", $string)){
  	echo "String mengandung -";
  	echo "</br>";
  	echo $string;
  }else{
  	$kd_rm1 = preg_split('//', $string, -1, PREG_SPLIT_NO_EMPTY);
 	$kd_rm2 = $kd_rm1[2].$kd_rm1[3].'-'.$kd_rm1[4].$kd_rm1[5].'-'.$kd_rm1[6].$kd_rm1[7];
 	echo $kd_rm2;
  }

} else {
  echo 'Tidak berawalan 0';
}
?>