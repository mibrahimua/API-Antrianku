<?php
require_once('config.php');

/*
 $query =("SELECT history as tanggal FROM ip_table ");
 $result=mysqli_query($conn,$query);
          // Ambil semua data dan masukkan ke variable $data

        while($value = mysqli_fetch_array($result)){
             echo $test = $value['tanggal'] ;
             echo "<br/>";
        }
        */
       



// FUNGSI
        $a="B.ANAK";
        $tanggalku = "06-11-2017";
        $tanggalku1 = date('Y-m-d', strtotime($tanggalku));
       echo $tanggalku2= tanggal_indo($tanggalku1, true);
function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array ( 1 =>    'senin',
                'selasa',
                'rabu',
                'kamis',
                'jumat',
                'sabtu',
                'minggu'
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
    $tgl_indo = $split[2];
    
    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num];
    }
    return $tgl_indo;
}
$sql = "SELECT b.hari,b.jam_mulai,b.jam_selesai,c.nick,c.nm_dokter,d.kd_poli,d.nm_poli,COUNT(e.id_antrian) AS jumlah_pasien
FROM ma_jadwal_dokter a JOIN ma_jadwal b ON a.id_hari = b.id_jadwal JOIN ma_dokter c ON a.kd_dok = c.kd_dok JOIN ma_poli d ON d.kd_poli = c.kd_poli JOIN ma_antrian e ON e.kd_poli = d.kd_poli WHERE b.hari = '$tanggalku2' AND d.kd_poli = '$a' AND e.tgl_antri = '$tanggalku1' AND e.verifikasi = 'J' 
GROUP BY a.id ORDER BY hari DESC;";
  $res = mysqli_query($con,$sql);
  $result = array();
  while($row = mysqli_fetch_array($res)){
    $result[]=$row;
    
  }

  $sql = "SELECT COUNT(e.id_antrian) AS jumlah_pasien_blmverif FROM ma_jadwal_dokter a JOIN ma_jadwal b ON a.id_hari = b.id_jadwal JOIN ma_dokter c ON a.kd_dok = c.kd_dok JOIN ma_poli d ON d.kd_poli = c.kd_poli JOIN ma_antrian e ON e.kd_poli = d.kd_poli WHERE b.hari = '$tanggalku2' AND d.kd_poli = '$a' AND e.tgl_antri = '$tanggalku1' AND e.verifikasi = 'B' 
GROUP BY a.id ORDER BY hari DESC;";
  $res = mysqli_query($con,$sql);
  while($row = mysqli_fetch_array($res)){
    $result[]=$row;
    
  }
  mysqli_close($con);
  $data = "{\"result\" : ".json_encode($result)."}";
  echo $data;

// AMBIL DATA DARI DATABASE

/*
// TAMPILKAN DATA
echo '<table>
            <thead>
                <tr>
                    <th>Judul Artikel</th>
                    <th>Tanggal Terbit</th>
                </tr>
            </thead>
            <tbody>';
            
while ($row = mysqli_fetch_array($result))
{
    // Ubah tanggal menjadi yyyy-mm-dd
    $tanggal = date('Y-m-d', strtotime($row['tanggal']));
    
    echo '<tr>
            <td>' . tanggal_indo($tanggal, true) . '</td>
        </tr>';
}

echo '</tbody>
    </table>';
    */
?>