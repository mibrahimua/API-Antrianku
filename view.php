<?php
require_once('config.php');
if($_SERVER['REQUEST_METHOD']=='GET') {
  $sql = "SELECT * FROM pasien";
  $res = mysqli_query($con,$sql);
  $result = array();
  while($row = mysqli_fetch_array($res)){
    array_push($result, array('norm'=>$row[0], 'nama_pasien'=>$row[1], 'tglLahir'=>$row[2], 'alamat_pasien'=>$row[3]));
  }
  echo json_encode(array("value"=>1,"result"=>$result));	
  mysqli_close($con);
}