<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();

$response = array("error" => FALSE);
$user =$db->listPoli();
 if ($user){
		$response["error"] = FALSE;
		$response["message"] = "Data sesuai";
        $response["result"]=$user;
		echo json_encode($response);
	} else {
            // gagal ambil data
            $response["error"] = TRUE;
            $response["message"] = "Terjadi Kesalahan, Silahkan Coba Lagi";
            echo json_encode($response);
        }
 
  ?>  
