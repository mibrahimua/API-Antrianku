<?php
require_once('config.php');
$a=$_GET['nm_dokter'];
$b=$_GET['kd_poli'];




header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');



$sql = "SELECT ma_dokter.nm_dokter,ma_dokter.nick,ma_poli.nm_poli,ma_poli.kd_poli FROM ma_dokter INNER JOIN ma_poli ON ma_dokter.kd_poli = ma_poli.kd_poli WHERE ma_dokter.nm_dokter LIKE '%$a%' AND ma_poli.kd_poli LIKE '$b' GROUP BY ma_dokter.nm_dokter";

//$sql = "SELECT nm_dokter,nick FROM ma_dokter WHERE nm_dokter LIKE '%$a%'";
$result = mysqli_query($con,$sql) or die ("Query error: " . mysqli_error());

$records = array();

while($row = mysqli_fetch_array($result)) 
{
 $records[] = $row;


}
$data = "{\"result\" : ".json_encode($records)."}";
echo $data;
 

mysqli_close($con);



//echo $_GET['jsoncallback'] . '(' . json_encode($records) . ');';
?>