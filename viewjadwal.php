<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
$kd_poli=$_GET['kd_poli'];
$b=$_GET['tgl_antri'];
$split=explode('/', $b);
$d = $split[0] . '-' .$split[1] . '-' .$split[2];
$e = $split[2] . '-' .$split[1] . '-' .$split[0];

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
// FUNGSI
        $tanggalku = date('Y/m/d', strtotime($d));//tanggal yy/mm/dd
        $hari= tanggal_indo($tanggalku, true);//hari
        $tgl_antri= tanggal_indo2($e, true);//hari
function tanggal_indo($tanggal, $cetak_hari = false)
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
    $split    = explode('/', $tanggal);
    $tgl_indo = $split[2];
    
    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num];
    }
    return $tgl_indo;
}
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
$i=0;
$dataJadwal = $db->dataJadwal($hari,$tanggalku,$tgl_antri,$kd_poli);
if($dataJadwal){
    $result["error"] = FALSE;
    $result["message"] = "Data sesuai";
    $result["result"]=$dataJadwal;
    
    echo json_encode($result);
}else{
        $response["error"] = TRUE;
        $response["message"] = "Maaf tidak ada jadwal untuk poli pada tanggal tersebut.";
       
        echo json_encode($response);
    }

    
  
/*
$sql = "SELECT a.nick,a.nm_dokter,b.kd_poli,b.nm_poli,d.hari,c.id_jam_mulai,c.id,
(SELECT COUNT(e.id_antrian) FROM ma_antrian e
        WHERE  e.tgl_antri = '$tanggalku' AND e.kd_poli = '$kd_poli' AND e.nick = a.nick AND e.verifikasi = 'B') AS jumlah_pasien,
(SELECT COUNT(e.id_antrian) FROM ma_antrian e
        WHERE  e.tgl_antri = '$tanggalku' AND e.kd_poli = '$kd_poli' AND e.nick = a.nick AND e.verifikasi = 'J') AS jumlah_pasien_blmverif
FROM ma_dokter a
        INNER JOIN ma_poli b ON a.kd_poli = b.kd_poli
        INNER JOIN ma_jadwal_dokter c ON a.kd_dok = c.kd_dok
        INNER JOIN ma_hari d ON d.id = c.id_hari
        WHERE  d.hari = '$hari' AND b.kd_poli ='$kd_poli' ";
  $res = mysqli_query($con,$sql);
  $result = array();

  while($row = mysqli_fetch_array($res)){
 $result[]=$row;
    }
  $sql2 = "SELECT COUNT(e.id_antrian) AS jumlah_pasien FROM ma_jadwal_dokter a JOIN ma_jadwal b ON a.id_hari = b.id_jadwal JOIN ma_dokter c ON a.kd_dok = c.kd_dok JOIN ma_poli d ON d.kd_poli = c.kd_poli JOIN ma_antrian e ON e.kd_poli = d.kd_poli WHERE b.hari = '$tanggalku1' AND d.kd_poli = '$a' AND e.tgl_antri = '$tanggalku' AND e.verifikasi = 'J' 
GROUP BY a.id ORDER BY hari DESC;";
  $res2 = mysqli_query($con,$sql2);
  $result2 = array();
  while($row = mysqli_fetch_array($res2)){
    
    $result2["jumlah_pasien"]=$row["jumlah_pasien"];
    array_push($result, $result2);
    
        $result2["jumlah_pasien"]="0";
        array_push($result, $result2);
     
  }
  mysqli_close($con);
   $data=json_encode(array("result" => $result ));

  //$data = "{\"result\" : ".json_encode($result)."}";
  echo $data;
  */
 
 

?>