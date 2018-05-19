<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new user
     * returns user details
     */
    public function tanggal_indo2($tanggal, $cetak_hari = false)
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

    public function cekRm($kd_rm,$rm){
        $i=0;
        $stmt = $this->conn->prepare("SELECT kd_rm,nm_pasien,tglLahir,alamat_pasien FROM ma_pasien WHERE kd_rm = ?");
        $stmt->bind_param("s",$kd_rm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $tgl2= tanggal_indo2($row['tglLahir'], false);//hari
            /*
            $jumlah_sensor=7;
            $index=12;
            //ambil 4 angka di tengah yan akan disensor
            $censored = mb_substr($row['alamat_pasien'], $index, $jumlah_sensor);
            //pecah kelompok angka pertama dan terakhir
            $alamat2=explode($censored,$row['alamat_pasien']);
            //gabung angka perama dan terakhir dengan angka tengah yang telah di sensor
            $alamatedit=$alamat2[0]."_______".$alamat2[1];
            //tampilkan
            */
            $alamat=$row['alamat_pasien'];
            $panjang_karakter = strlen($alamat);
            if($panjang_karakter <= 20){
                $minus = 7;
                $kata_depan = 4;
            }elseif($panjang_karakter <= 25){
                $minus = 10;
                $kata_depan = 12;
            }
            elseif($panjang_karakter <= 30){
                $minus = 18;
                $kata_depan = 13;
            }else{
                $minus = 18;
                $kata_depan = 13;
            }
            $count = $panjang_karakter - $minus;
            $alamatedit = substr_replace($alamat, str_repeat('*', $count), $kata_depan, $count);
                        
            $user[$i]["status"]="1";
            $user[$i]["kd_rm_edit"]=$rm;
            $user[$i]["kd_rm"]=$row["kd_rm"];
            $user[$i]["nm_pasien"]=$row["nm_pasien"];
            $user[$i]["tglLahir"]=$tgl2;
            $user[$i]["alamat_pasien"]=$alamatedit;
            

            $i++;
             return $user;
            }
        }else{
            /*
          $user[]["status"]="0";
          $user[$i]["kd_rm"]="Tidak ada data";
          $user[$i]["nm_pasien"]="Tidak ada data";
          $user[$i]["tglLahir"]="Tidak ada data";
          $user[$i]["alamat_pasien"]="Tidak ada data";
          $i++;
          */
          return false;
        }
        
           
            $stmt->close();
            return $user;
        }else{
            return false;
        }
    }

    public function insertData($tgl2,$newRm,$kd_poli,$nick,$telp_pasien,$penjamin){
        $stmt = $this->conn->prepare("INSERT INTO ma_antrian (id_antrian, tgl_antri, kd_rm, telp_pasien, nick, kd_poli, penjamin) SELECT MAX(id_antrian)+1, ?, ?, ?, ?, ?, ? FROM ma_antrian");
        $stmt->bind_param("ssssss", $tgl2, $newRm, $telp_pasien, $nick, $kd_poli, $penjamin);
        $result = $stmt->execute();
        $stmt->close();

        if($result) {
            $stmt = $this->conn->prepare("SELECT ma_antrian.id_antrian, ma_antrian.kd_rm, ma_antrian.nick, ma_antrian.kd_poli, ma_antrian.tgl_antri, ma_antrian.telp_pasien,ma_antrian.penjamin,DATE_FORMAT(`tgl_sms`,  '%e-%m-%Y %H:%i:%s') as tgl_sms ,ma_pasien.nm_pasien, ma_pasien.tglLahir, ma_pasien.alamat_pasien,ma_poli.nm_poli,ma_dokter.nm_dokter
                FROM ma_antrian JOIN ma_pasien ON ma_antrian.kd_rm = ma_pasien.kd_rm
                JOIN ma_poli ON ma_antrian.kd_poli = ma_poli.kd_poli JOIN ma_dokter ON ma_antrian.nick = ma_dokter.nick
                WHERE ma_antrian.id_antrian = (SELECT MAX(ma_antrian.id_antrian) FROM ma_antrian) AND ma_antrian.kd_rm = ? AND ma_antrian.nick = ? 
                AND ma_antrian.kd_poli = ? 
                AND ma_antrian.tgl_antri = ? ");
            $stmt->bind_param("ssss",$newRm,$nick,$kd_poli,$tgl2);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();

            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }

    public function cekRegis($newRm,$nick,$tgl2){
      $stmt = $this->conn->prepare("SELECT kd_rm,nick,tgl_antri FROM ma_antrian WHERE kd_rm = ? AND nick = ? AND tgl_antri = ? AND verifikasi = 'B'");
        
        $stmt->bind_param("sss",$newRm,$nick,$tgl2);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
   
    public function listPoli(){
        $i=0;
        $stmt = $this->conn->prepare("SELECT kd_poli,nm_poli FROM ma_poli GROUP BY nm_poli ORDER BY nm_poli ASC");
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            /*
            if($row){
            $user[]=$row;
            $user['tgl']=$tgl_antri;
                    }
            */
            $user[$i]["status"]="1";
            $user[$i]["kd_poli"]=$row["kd_poli"];
            $user[$i]["nm_poli"]=$row["nm_poli"];

            $i++;
            
            }
        }else{
          $user[$i]["status"]="0";
          $user[$i]["kd_poli"]="Tidak Ada Jadwal";
          $user[$i]["nm_poli"]="Tidak Ada Jadwal";
        }
        
           
            $stmt->close();
            return $user;
        }else{
            return false;
        }
    }

    public function dataJadwal($hari,$tanggal,$tgl_antri,$kd_poli){
        $i=0;
        $stmt = $this->conn->prepare("SELECT a.nick,a.nm_dokter,b.kd_poli,b.nm_poli,d.hari,
(SELECT COUNT(e.id_antrian) FROM ma_antrian e
        WHERE  e.tgl_antri = '$tanggal' AND e.kd_poli = b.kd_poli AND e.nick = a.nick AND e.verifikasi = 'J') AS jumlah_pasien,
(SELECT COUNT(e.id_antrian) FROM ma_antrian e
        WHERE  e.tgl_antri = '$tanggal' AND e.kd_poli = b.kd_poli AND e.nick = a.nick AND e.verifikasi = 'B') AS jumlah_pasien_blmverif
FROM ma_dokter a
        INNER JOIN ma_poli b ON a.kd_poli = b.kd_poli
        INNER JOIN ma_jadwal_dokter c ON a.kd_dok = c.kd_dok
        INNER JOIN ma_hari d ON d.id = c.id_hari
        WHERE  d.hari = ? AND b.kd_poli =? ");
        $stmt->bind_param("ss",$hari,$kd_poli);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            /*
            if($row){
            $user[]=$row;
            $user['tgl']=$tgl_antri;
                    }
            */
            $user[$i]["status"]="1";
            $user[$i]["nick"]=$row["nick"];
            $user[$i]["nm_dokter"]=$row["nm_dokter"];
            $user[$i]["kd_poli"]=$row["kd_poli"];
            $user[$i]["nm_poli"]=$row["nm_poli"];
            $user[$i]["hari"]=$row["hari"];
            $user[$i]["jumlah_pasien"]=$row["jumlah_pasien"];
            $user[$i]["jumlah_pasien_blmverif"]=$row["jumlah_pasien_blmverif"];
            $user[$i]['tanggal']=$tgl_antri;

           
            $i++;
            }
        }else{
          return false;
        }
        
           
            $stmt->close();
            return $user;
        }else{
            return false;
        }
    }

    public function cekPasien($hari,$kd_poli,$nick,$tgl_antri){
        $stmt = $this->conn->prepare("SELECT COUNT(e.id_antrian) AS jumlah_pasien FROM ma_jadwal_dokter a JOIN ma_jadwal b ON a.id_hari = b.id_jadwal JOIN ma_dokter c ON a.kd_dok = c.kd_dok JOIN ma_poli d ON d.kd_poli = c.kd_poli JOIN ma_antrian e ON e.kd_poli = d.kd_poli WHERE b.hari = ? AND e.kd_poli = ? AND e.nick = ?  AND e.tgl_antri = ? AND e.verifikasi = 'J' 
            GROUP BY e.id_antrian ORDER BY hari DESC");
        $stmt->bind_param("ssss",$hari,$kd_poli,$nick,$tgl_antri);
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        }else{
            return false;
        }
    }

    public function cekPasienBlmverif($hari,$kd_poli,$tgl_antri){
        $stmt = $this->conn->prepare("SELECT COUNT(e.id_antrian) AS jumlah_pasien_blmverif FROM ma_jadwal_dokter a JOIN ma_jadwal b ON a.id_hari = b.id_jadwal JOIN ma_dokter c ON a.kd_dok = c.kd_dok JOIN ma_poli d ON d.kd_poli = c.kd_poli JOIN ma_antrian e ON e.kd_poli = d.kd_poli WHERE b.hari = ? AND d.kd_poli = ? AND e.tgl_antri = ? AND e.verifikasi = 'B' 
            GROUP BY e.id_antrian ORDER BY hari DESC");
        $stmt->bind_param("sss",$hari,$kd_poli,$tgl_antri);
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        }else{
            return false;
        }
    }



    public function storeUser($name, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email, encrypted_password, salt, created_at) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $uuid, $name, $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }




    /**
    * menampilkan list user
    */
    public function getListUser(){

        $stmt = $this->conn->prepare("SELECT name FROM users");

        if ($stmt->execute()){
            $user = $stmt->get_result();
            $stmt->close();
        }
        else {
            return NULL;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

}

?>
