<?php
$koneksi = mysqli_connect('localhost', 'root', '','sms_roemani');

$kd_poli=$_GET['kd_poli'];
$b=$_GET['tgl_antri'];




//print_r($jadwal2);
$hari = array ( 0 =>    'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            );
function tanggal_indo2($tanggal, $cetak_hari = true)
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
        return $hari[$num];
    }
    return $tgl_indo;
}
$jadwal_array = array();
$response = array();
  $response2 = array();

$e = "11-06-2018";
$tgl_hari= tanggal_indo2($e, true);//hari
//echo $tgl_hari."<br />";

$query = "SELECT DISTINCT nama, jam_kerja FROM roe_dokter WHERE spesialis = 'S-9' AND status = '1'";
$sql = mysqli_query($koneksi, $query);
while ($data = mysqli_fetch_array($sql)) {
	//echo $data['nama']."<br />";
	$jadwal2 = explode(';', $data['jam_kerja']);
	foreach (array_values($jadwal2) as $i => $value) {
  
	if((empty($value) && 0 !== $value)){
		
	}else{
		$jadwal_dokter = $hari[$i];
		array_push($jadwal_array, $jadwal_dokter);
	}
}
	if(in_array($tgl_hari, $jadwal_array, true)){
		$data_array = array(
		'status' => '1',
		'nick' => $data['nama'],
		'nm_dokter' => $data['nama'],
		'kd_poli' => 'THT',
		'nm_poli' => 'Poli THT',
		'hari' => $tgl_hari,
		'tanggal' => 'Senin, 5 Juni 2018'
		);
		array_push($response2, $data_array);
	}else{
		echo "tidak ada jadwal";
	}


}
$response["error"] = FALSE;
$response["message"] = "Data sesuai";
$response["result"]=$response2;
echo json_encode($response);
/*

foreach (array_values($jadwal2) as $i => $value) {
  
	if((empty($value) && 0 !== $value)){
		
	}else{
		$jadwal_dokter = $hari[$i];
		array_push($jadwal_array, $jadwal_dokter);
	}
}
if(in_array($tgl_hari, $jadwal_array, true)){
	echo "ada jadwal";
}else{
	echo "tidak ada jadwal";
}
*/

?>