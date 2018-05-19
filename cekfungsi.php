<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();


$kd_rm = $_POST['kd_rm'];
$nick = $_POST['nick'];
$tgl_antri = $_POST['tgl_antri'];

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

if ($db->cekRegis($newRm,$nick,$tgl2)){
        $response["error"] = TRUE;
        $response["message"] = "Maaf No RM ".$newRm.  " Telah Terdaftar Pada Tanggal ".$tgl2." ,Mohon Untuk Dapat Menunggu Balasan Dari Operator Kami";
        echo json_encode($response);
    } else{
        $response["error"] = FALSE;
        $response["message"] = "Bisa daftar";
        echo json_encode($response);
    }





    ?>