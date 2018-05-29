<?php
if(isset($_GET['id_post'])){
$id_post = $_GET['id_post'];
@$json_data=file_get_contents("http://rsroemani.com/rv2/wp-json/wp/v2/posts/".$id_post);
$json_object = json_decode($json_data, true);
if(!isset($json_object['code'])){
	

$author = $json_object['author'];

if(!is_null($author)){
	$json_data_author=file_get_contents("http://rsroemani.com/rv2/wp-json/wp/v2/users/".$author);
	$json_object_author = json_decode($json_data_author, true);
	
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Infoku</title>
	<meta charset="utf-8">
	<meta name="viewport" content="widht=device-widht, initial-scale=1">
	<link rel="stylesheet" href="lib/bootstrap.min.css">
	<script src="lib/jquery.min.js"></script>
	<script src="lib/bootstrap.min.js"></script>
	<style>
		img {
    max-width: 100%;
    height: auto;
    }
    div.judul{
    	margin-top: 10px;
    	margin-bottom: 10px;
    	font-size: 20px;
    	text-align: center;
    	font-weight: bold;
    }
    div.tgl_upload{
    	font-size: 14px;
    	margin-bottom: 10px;
    }
    div.isi_info{
    	font-size: 16px;
    }
	</style>
</head>
<body>
<?php 
?>
<div class="container-fluid">
	<div class="judul">
		<?php echo $json_object['title']['rendered']."<br />"; ?>
	</div>
<div class="tgl_upload">
<?php echo $json_object['date']."<br />"; ?>
<?php echo "Oleh : ".@$json_object_author['name']; ?>
 </div>
 <div class="isi_info">
<?php echo $json_object['content']['rendered']; ?>
</div>
<?php
}else{
	echo $json_object['code'];
	echo "aaa";
}
}elseif(isset($_GET['list_info'])){
	$page=10;
$json_data_list=file_get_contents("http://rsroemani.com/rv2/wp-json/wp/v2/posts?per_page=".$page);
$json_object_list = json_decode($json_data_list, true);
 $response = array();
 
foreach ($json_object_list as $mydata) {
	$data = array(
	'id' => $mydata['id'],
	'title' => $mydata['title']['rendered'],
	'date' => $mydata['date']);
	array_push($response, $data);
}

echo json_encode($response);
}else{
	echo "Data tidak ditemukan";
}
?>
   </div>             
</body>
</html>