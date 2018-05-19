<?php

require_once('config.php');
 
 
 
 $name = $_POST['nama_pasien'];
 

 $Sql_Query = "INSERT INTO pasien (nama_pasien) VALUES ('$name')";
 
 if(mysqli_query($con,$Sql_Query)){
 
 echo 'Data Submit Successfully';
 
 }
 else{
 
 echo 'Try Again';
 
 }
 mysqli_close($con);
?>