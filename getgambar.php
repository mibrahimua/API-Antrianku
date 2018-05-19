<html>
<head>
	<title>Upload & Menyimpan Gambar di Database by TUTORIALWEB.NET</title>
</head>
<body>

	<h1>Upload Image</h1>

	<form action="" method="post" enctype="multipart/form-data">
		Pilih File : <input type="file" name="image"> <input type="submit" value="Upload">
	</form>

	<?php
	require_once('config.php');
	//koneksi ke database


	$file = $_FILES['gambar']['tmp_name'];

	if(!isset($file)){
		echo 'Pilih file gambar';
	}else{
		$image 		= addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
		$image_name	= addslashes($_FILES['gambar']['name']);
		$image_size	= getimagesize($_FILES['gambar']['tmp_name']);

		if($image_size == false){
			echo 'File yang anda pilih tidak gambar';
		}else{
			if(!$insert = mysql_query("INSERT INTO table_gambar VALUES(NULL, '$image_name', '$image')")){
				echo 'Gagal upload gambar';
			}else{
				//ambil id terakhir insert
				$lastid = mysql_insert_id();

				echo 'Gambar berhasil di upload.<p>Gambar anda:</p><img src="get.php?id='.$lastid.'">';
			}
		}
	}
	?>

</body>
</html>