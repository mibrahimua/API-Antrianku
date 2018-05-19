 
<?php
require_once('config.php');
if($_SERVER['REQUEST_METHOD']=='POST') {
  $search = $_POST['search'];
  $sql = "SELECT * FROM pasien where norm = $search";
  $res = mysqli_query($con,$sql);
  $result = array();
  if(($row = mysqli_fetch_array($res))){
    array_push($result, array('norm'=>$row[0], 'nama_pasien'=>$row[1], 'tglLahir'=>$row[2], 'alamat_pasien'=>$row[3]));
  
  echo json_encode(array("value"=>1,"result"=>$result));
  mysqli_close($con);
}else {
       $response["value"] = 0;
       $response["message"] = "Maaf No RM Anda Tidak Sesuai";
       echo json_encode($response);
     }
}