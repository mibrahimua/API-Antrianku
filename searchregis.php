<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();

$response = array("error" => FALSE);

//header('Content-type: application/json');
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: POST, GET, OPTIONS');


if(isset($_POST['kd_rm'])&&isset($_POST['kd_poli'])&&isset($_POST['nick'])&&isset($_POST['tgl_antri'])&&isset($_POST['telp_pasien'])&&isset($_POST['penjamin'])) {

 $kd_rm = $_POST['kd_rm'];

 $kd_poli = $_POST['kd_poli'];

 $tgl_antri = $_POST['tgl_antri'];

 $nick = $_POST['nick'];

 $telp_pasien = $_POST['telp_pasien'];

 $penjamin = $_POST['penjamin'];

$tgl1 = explode('/', $tgl_antri);
$tgl2 = $tgl1[2].'-'.$tgl1[1].'-'.$tgl1[0];

$tgl3 = explode('/', $tgl_antri);
$tgl4 = $tgl3[0].'-'.$tgl3[1].'-'.$tgl3[2];


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

	

						

	if ($db->cekRegis($kd_rm,$nick,$tgl2)){
		$response["error"] = TRUE;
		$response["message"] = "Maaf No RM ".$kd_rm.  " Telah Terdaftar Pada Tanggal ".$tgl4." , Mohon Untuk Dapat Menunggu Balasan Dari Operator Kami";
		echo json_encode($response);
	} else {

		$user = $db->insertData($tgl2,$kd_rm,$kd_poli,$nick,$telp_pasien,$penjamin);
		if($user) {
			$tgl5 = explode('-', $user["tglLahir"]);
			$tgl6 = $tgl5[2].'-'.$tgl5[1].'-'.$tgl5[0];

			//$tgl7 = explode('-', $user["tgl_antri"]);
			//$tgl8 = $tgl7[2].'-'.$tgl7[1].'-'.$tgl7[0];

			$tgl_antri2= tanggal_indo2($user["tgl_antri"], true);//hari

			$jumlah_sensor=7;
			$index=12;
			//ambil 4 angka di tengah yan akan disensor
			$censored = mb_substr($user['alamat_pasien'], $index, $jumlah_sensor);
			//pecah kelompok angka pertama dan terakhir
			$alamat2=explode($censored,$user['alamat_pasien']);
			//gabung angka perama dan terakhir dengan angka tengah yang telah di sensor
			$alamatedit=$alamat2[0]."_______".$alamat2[1];
			//tampilkan

			$response["error"] = FALSE;
			$response["message"] = "Tidak ada jadwal periksa";
			$response["id_antrian"] = $user["id_antrian"];
			$response["kd_rm"] = $user["kd_rm"];
			$response["nm_pasien"] = $user["nm_pasien"];
			$response["tglLahir"] = $tgl6;
			$response["telp_pasien"] = $user["telp_pasien"];
			$response["alamat_pasien"] = $user["alamat_pasien"];
			$response["nick"] = $user["nick"];
			$response["nm_dokter"] = $user["nm_dokter"];
			$response["kd_poli"] = $user["kd_poli"];
			$response["nm_poli"] = $user["nm_poli"];
			$response["tgl_antri"] = $tgl_antri2;
			$response["penjamin"] = $user["penjamin"];
			$response["alamat_pasien_edit"] = $alamatedit;
			$response["tgl_sms"] = $user["tgl_sms"];
			echo json_encode($response);
		} else {
            // user failed to store
            $response["error"] = TRUE;
            $response["message"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
	}
} else {
	$response["error"] = TRUE;
	$response["message"] = "Required parameters (kd_rm, kd_poli or nick) is missing!";
    echo json_encode($response);
}				
 
?>