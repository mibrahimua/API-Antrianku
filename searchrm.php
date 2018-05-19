<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();

$rm=$_GET['kd_rm'];
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');



if(isset($rm)) {

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
					$newRm = getRMFormat($rm);
					//print $newRm;

					function tanggal_indo2($tanggal, $cetak_hari = false)
						{
						    $hari = array ( 1 =>    'Senin',
						                'Selasa',
						                'Rabu',
						                'Kamis',
						                'Jumat',
						                'Sabtu',
						                'Minggu'
						            );
						            
						    $bulan = array (1 =>   'Januari',
						                'Februari',
						                'Maret',
						                'April',
						                'Mei',
						                'Juni',
						                'Juli',
						                'Agustus',
						                'September',
						                'Oktober',
						                'November',
						                'Desember'
						            );
						    $split    = explode('-', $tanggal);
						    $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
						    
						    if ($cetak_hari) {
						        $num = date('N', strtotime($tanggal));
						        return $hari[$num] . ', ' . $tgl_indo;
						    }
						    return $tgl_indo;
						}
					
	if ($data_pasien = $db->cekRm($newRm,$rm)){
		$response["error"] = FALSE;
		$response["message"] = "Data sesuai";
        $response["result"]=$data_pasien;
        
        echo json_encode($response);
    } else{
        $response["error"] = TRUE;
        $response["message"] = "Maaf No RM Anda Tidak Sesuai";
       
        echo json_encode($response);
    }				

  
/*
$sql = "SELECT kd_rm,nm_pasien,tglLahir,alamat_pasien FROM ma_pasien WHERE kd_rm = '$newRm'";
$result = mysqli_query($con,$sql) or die ("Query error: " . mysqli_error());

$records = array();

if(($row = mysqli_fetch_array($result))) {
 $records[] = $row;
 
$tgl2= tanggal_indo2($row['tglLahir'], false);//hari

// $tgl1 = explode('-', $row['tglLahir']);
//$tgl2 = $tgl1[2].'-'.$tgl1[1].'-'.$tgl1[0];


$jumlah_sensor=7;
$index=12;
//ambil 4 angka di tengah yan akan disensor
$censored = mb_substr($row['alamat_pasien'], $index, $jumlah_sensor);
//pecah kelompok angka pertama dan terakhir
$alamat2=explode($censored,$row['alamat_pasien']);
//gabung angka perama dan terakhir dengan angka tengah yang telah di sensor
$alamatedit=$alamat2[0]."_______".$alamat2[1];
//tampilkan


$records[0]['tgledit']=$tgl2;
$records[0]['alamat_pasien_edit'] = $alamatedit;


}else{
	$response["message"] = "Maaf No RM Anda Tidak Sesuai";
       echo json_encode($response);
}
mysqli_close($con);
$data = "{\"result\" : ".json_encode($records)."}";
echo $data;
//echo $_GET['jsoncallback'] . '(' . json_encode($records) . ');';

*/
}
?>