<?php
require_once('config.php');
$a=$_GET['kd_rm'];
$b=$_GET['id_antrian'];
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');



$sql = "SELECT ma_pasien.kd_rm,ma_pasien.nm_pasien,ma_pasien.tglLahir,ma_pasien.alamat_pasien
,ma_poli.nm_poli,ma_antrian.tgl_antri,ma_dokter.nm_dokter,ma_antrian.telp_pasien,ma_antrian.penjamin
FROM ma_pasien
JOIN ma_antrian ON ma_pasien.kd_rm = ma_antrian.kd_rm
JOIN ma_dokter ON ma_antrian.nick = ma_dokter.nick
JOIN ma_poli ON ma_antrian.kd_poli = ma_poli.kd_poli
WHERE ma_antrian.kd_rm = $a AND ma_antrian.id_antrian = $b;";
$result = mysqli_query($con,$sql) or die ("Query error: " . mysqli_error());

$records = array();

if(($row = mysqli_fetch_array($result))) {
 $records[] = $row;
 mysqli_close($con);
$data = "{\"result\" : ".json_encode($records)."}";
echo $data;
}else{
	$response["message"] = "Maaf No RM Anda Tidak Sesuai";
       echo json_encode($response);
}


//echo $_GET['jsoncallback'] . '(' . json_encode($records) . ');';
?>