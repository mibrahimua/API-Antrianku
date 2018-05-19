<?php
require_once('config.php');
$a=$_GET['kd_poli'];

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

  $sql = "SELECT ma_poli.kd_poli,ma_poli.nm_poli,ma_dokter.nick,ma_dokter.nm_dokter FROM ma_poli INNER JOIN ma_dokter ON ma_poli.kd_poli = ma_dokter.kd_poli WHERE ma_poli.kd_poli LIKE '$a' GROUP BY ma_dokter.nm_dokter ORDER BY ma_poli.nm_poli ASC";
  $res = mysqli_query($con,$sql);
  $result = array();
  while($row = mysqli_fetch_array($res)){
    $result[]=$row;
  }
  mysqli_close($con);
  $data = "{\"result\" : ".json_encode($result)."}";
  echo $data;
 
  ?>  
